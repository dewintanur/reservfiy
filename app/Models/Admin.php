<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins'; // Memastikan ini sesuai dengan nama tabel

    protected $fillable = [
        'username', 'password', 'role'
    ];

    protected $hidden = [
        'password',  // Sembunyikan password dalam array
    ];
}
