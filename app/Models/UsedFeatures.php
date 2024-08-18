<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedFeatures extends Model
{
    use HasFactory;
    protected $fillable = [
        'credits',
        'feature_id',
        'user_id',
        'data'
    ];
    protected function casts():array
    {
        return [
           'data'=>'array',
        ];
    }

    public function user (){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function feature (){
        return $this->belongsTo(Features::class,'feature_id');
    }

}
