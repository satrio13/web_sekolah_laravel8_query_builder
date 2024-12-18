<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class GuruModel
{
    protected $table = 'tb_guru';

    function list_guru()
    {
        return DB::table($this->table)->orderBy('id','desc')->get();
    }

    function cek_guru($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->where('id', $id)->first();
    }

    function get_guru($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_guru($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_guru($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_guru($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}