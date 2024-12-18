<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class KalenderModel
{
    protected $table = 'tb_kalender';

    function get_kalender()
    {
        return DB::table($this->table)->where('id', 1)->first();    
    }

    function update_kalender($data)
    {
        return DB::table($this->table)->where('id', 1)->update($data);
    }

}