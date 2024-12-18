<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class AuthModel
{
    protected $table = 'tb_user';

    function cek_user($username)
    {
        return DB::table($this->table)->where('username', $username)->first();
    }
    
}