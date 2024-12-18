<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class VisiMisiModel
{
    protected $table = 'tb_visimisi';

    function get_visi_misi()
    {
        return DB::table($this->table)->where('id', 1)->first();
    }

    function update_visi_misi($data)
    {
        return DB::table($this->table)->where('id', 1)->update($data);
    }

}