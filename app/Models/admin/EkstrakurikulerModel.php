<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class EkstrakurikulerModel
{
    protected $table = 'tb_ekstrakurikuler';

    function list_ekstrakurikuler()
    {
        return DB::table($this->table)->orderBy('id','desc')->get();
    }

    function cek_ekstrakurikuler($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->where('id', $id)->first();
    }

    function get_ekstrakurikuler($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_ekstrakurikuler($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_ekstrakurikuler($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_ekstrakurikuler($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}