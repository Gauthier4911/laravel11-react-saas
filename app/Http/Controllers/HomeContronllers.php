<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Models\Features;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeContronllers extends Controller
{
   public function index(){
       $features =Features::where('active', true)->get();
       return Inertia::render('Welcome', [
           'features' => FeatureResource::collection($features),
           'canLogin' => Route::has('login'),
           'canRegister' => Route::has('register'),
       ]);
   }
}
