<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsedFeatureResource;
use App\Models\UsedFeatures;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardContronllers extends Controller
{
    public function index()
    {
        $usedFeatures = UsedFeatures::query()->with(['feature'])->where("user_id",auth()->user()->id)->latest()->paginate();
        return Inertia::render("Dashboard", [
            'usedFeatures' => UsedFeatureResource::collection($usedFeatures),
        ]);
    }
}
