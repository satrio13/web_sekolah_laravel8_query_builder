<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class FotoModel
{
    protected $table = 'tb_foto';

    function list_foto()
    {
        return DB::table('tb_foto')->select('tb_foto.*', 'tb_album.album')->join('tb_album','tb_foto.id_album', '=', 'tb_album.id_album')->orderBy('tb_foto.id_foto','desc')->get();
    }
    
    function get_foto($id)
    {
        return DB::table($this->table)->where('id_foto', $id)->first();
    }

    function simpan_foto($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function hapus_foto($id)
    {
        return DB::table($this->table)->where('id_foto', $id)->delete();
    }

}