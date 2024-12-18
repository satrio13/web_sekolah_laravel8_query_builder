<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class PengaduanModel
{
    protected $table = 'tb_pengaduan';

    function list_pengaduan()
    {
        return DB::table($this->table)->orderBy('id','desc')->get();
    }

    function cek_pengaduan($id)
    {
        return DB::table($this->table)->select('id')->where('id', $id)->first();
    }

    function get_pengaduan($id)
    {
        return DB::table($this->table)->find($id);
    }

    function hapus_pengaduan($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}