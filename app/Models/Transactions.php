<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'price',
        'credits',
        'session_id',
        'user_id',
        'package_id'
    ];

    public function user (){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function package (){
        return $this->belongsTo(Packages::class, 'package_id');
    }
}
