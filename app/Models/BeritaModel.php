<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class BeritaModel
{
    protected $table = 'tb_berita';

    function list_berita($page)
    {
        return DB::table('tb_berita')->where('is_active', 1)->orderBy('id','desc')->paginate($page);
    }

    function list_berita_cari($page, $keyword)
    {
        return DB::table('tb_berita')->where('is_active', 1)->where('nama', 'like', '%'.$keyword.'%')->orderBy('id','desc')->paginate($page);
    }

    function cek_berita($slug)
    {
        return DB::table($this->table)->select('slug','dibaca')->where('slug', $slug)->first();
    }

    function get_berita($slug)
    {
        return DB::table($this->table)->where('slug', $slug)->first();
    }

    function update_dibaca($data, $slug)
    {
        return DB::table($this->table)->where('slug', $slug)->update($data);
    }

}