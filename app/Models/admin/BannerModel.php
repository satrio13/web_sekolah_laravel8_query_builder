<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class BannerModel
{
    protected $table = 'tb_banner';

    function list_banner()
    {
        return DB::table($this->table)->orderBy('id','desc')->get();
    }

    function cek_banner($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->where('id', $id)->first();
    }

    function get_banner($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_banner($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_banner($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_banner($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}