<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class GuruModel
{
    protected $table = 'tb_guru';

    function list_guru()
    {
        return DB::table($this->table)->orderBy('nama','asc')->get();
    }

    function cek_guru($id)
    {
        return DB::table($this->table)->select('id')->where('id', $id)->first();
    }

    function get_guru($id)
    {
        return DB::table($this->table)->where('id', $id)->first();
    }

}