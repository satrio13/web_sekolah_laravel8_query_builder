<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class KaryawanModel
{
    protected $table = 'tb_karyawan';

    function list_karyawan()
    {
        return DB::table($this->table)->orderBy('id','desc')->get();
    }

    function cek_karyawan($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->where('id', $id)->first();
    }

    function get_karyawan($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_karyawan($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_karyawan($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_karyawan($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}