<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class KaryawanModel
{
    protected $table = 'tb_karyawan';

    function list_karyawan()
    {
        return DB::table($this->table)->orderBy('nama','asc')->get();
    }

    function cek_karyawan($id)
    {
        return DB::table($this->table)->select('id')->where('id', $id)->first();
    }

    function get_karyawan($id)
    {
        return DB::table($this->table)->where('id', $id)->first();
    }

}