<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class AlbumModel
{
    protected $table = 'tb_album';

    function list_album()
    {
        return DB::table($this->table)->orderBy('id_album','desc')->get();
    }

    function list_album_order_by_name_asc()
    {
        return DB::table($this->table)->orderBy('album','asc')->get();
    }

    function cek_album($id)
    {
        return DB::table($this->table)->select('id_album')->where('id_album', $id)->first();
    }

    function get_album($id)
    {
        return DB::table($this->table)->where('id_album', $id)->first();
    }

    function simpan_album($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_album($data, $id)
    {
        return DB::table($this->table)->where('id_album', $id)->update($data);
    }

    function hapus_album($id)
    {
        return DB::table($this->table)->where('id_album', $id)->delete();
    }
    
    function cek_album_foto($id)
    {
        return DB::table('tb_foto')->select('id_album')->where('id_album', $id)->first();
    }

}