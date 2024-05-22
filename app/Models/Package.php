<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{

    protected $fillable = ['name', 'price', 'description', 'cafe_id'];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }}
