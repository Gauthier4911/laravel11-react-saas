<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Http\Resources\PackagesResource;
use App\Models\Features;
use App\Models\Packages;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;

class CreditContronllers extends Controller
{
    public function index (){
        $packages = Packages::all();
        $features = Features::where('active',true)->get();
        return inertia("Credit/Index", [
            'packages' => PackagesResource::collection($packages),
            'features' => FeatureResource::collection($features),
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    public  function buyCredits(Packages $package){
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $package->name . ' - ' . $package->credits . ' credits ',
                        ],
                        'unit_amount' => $package->price * 100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('credit.success', [], true),
            'cancel_url' => route('credit.cancel', [], true),
        ]);
        Transactions::create([
            'status' => 'pending',
            'price' => $package->price,
            'credits' => $package->credits,
            'session_id' => $checkout_session->id,
            'user_id' => Auth::id(),
            'package_id' => $package  ->id,
        ]);

        return redirect($checkout_session->url);
    }

    public function success(){
        return to_route('credit.index')
            ->with('success', 'You have successfully bought new credits.');
    }

    public function cancel(){
        return to_route('credit.index')
            ->with('error', 'There was an error in payment process. Please try again.');
    }

    public function webhook(){
      $endpoint_secret = env('STRIPE_WEBHOOK');
      $payload = @file_get_contents('php://input');
      $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
      $event = null;

        try {
             $event = \Stripe\Webhook::constructEvent(
               $payload,
               $sig_header,
               $endpoint_secret
             );
        } catch (\UnexpectedValueException $e) {
            return response('' , 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e){
            return response('' , 400);
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $transaction = Transactions::where('session_id',$session->id)->first();
                if ($transaction && $transaction->status === 'pending'){
                    $transaction->status = 'paid';
                    $transaction->save();
                    $transaction->user->available_credits +=
                    $transaction->credits;
                    $transaction->user->save();
                }

            default:
                echo 'Received unknown event type ' . $event->type;
        }
        return response('');
    }

}
