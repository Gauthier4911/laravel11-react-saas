<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Models\Features;
use App\Models\UsedFeatures;
use Illuminate\Http\Request;

class Feature2Contronllers extends Controller
{
    public ?Features $features = null;

    public function __construct()
    {
        $this->features = Features::where("route_name","feature2.index")
            ->where('active',true)
            ->firstOrFail();
    }
    public function index(){
        return inertia('Feature2/Index',[
            'feature'=> new FeatureResource($this->features),
            'answer' => session('answer')
        ]);
    }

    public function calculate(Request $request){
        $user = $request->user();
        if ($user->available_credits < $this->features->required_credits){
            return back();
        }
        $data = $request->validate([
            'number1' => ['required','numeric'],
            'number2' => ['required','numeric'],
        ]);
        $number1 = (float) $data['number1'];
        $number2 = (float) $data['number2'];

        $user->decreaseCredits($this->features->required_credits);
        UsedFeatures::create([
            'credits' => $this->features->required_credits,
            'feature_id' => $this->features->id,
            'user_id' => $user->id,
            'data'=> $data,
        ]);

        return  to_route('feature2.index')->with('answer', $number1 - $number2);
    }
}
