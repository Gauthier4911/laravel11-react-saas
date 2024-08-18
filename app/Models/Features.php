<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'route_name',
        'name',
        'desc',
        'required_credits',
        'active'
    ];
    public function usedFeature()
    {
        return $this->hasMany(UsedFeatures::class,'feature_id');
    }
}
