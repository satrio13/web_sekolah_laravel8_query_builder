<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class SarprasModel
{
    protected $table = 'tb_sarpras';

    function get_sarpras()
    {
        return DB::table($this->table)->where('id', 1)->first();
    }

    function update_sarpras($data)
    {
        return DB::table($this->table)->where('id', 1)->update($data);
    }

}