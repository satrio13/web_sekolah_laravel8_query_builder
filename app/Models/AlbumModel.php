<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class AlbumModel
{
    protected $table = 'tb_album';

    function list_album($page)
    {
        return DB::table($this->table)->where('is_active', 1)->orderBy('created_at','desc')->paginate($page);
    }

    function cek_album($slug)
    {
        return DB::table($this->table)->where('slug', $slug)->where('is_active', 1)->first();
    }

    function get_album($slug)
    {
        return DB::table($this->table)->where('is_active', 1)->first();
    }

    function list_foto($slug)
    {
        return DB::table('tb_foto')->select('tb_foto.*', 'tb_album.*')->join('tb_album','tb_foto.id_album', '=', 'tb_album.id_album')->where('tb_album.is_active',1)->where('tb_album.slug', $slug)->orderBy('tb_foto.created_at','desc')->get();
    }

}