<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class HomeModel
{
    function berita_populer($slug)
    {
        return DB::table('tb_berita')->select('id','nama','gambar','dibaca','is_active','hari','created_at','slug')->where('is_active', 1)->where('slug', '!=', $slug)->orderBy('dibaca','desc')->limit(3,0)->get();
    }

    function link_terkait()
    {
        return DB::table('tb_link')->where('is_active', 1)->orderBy('id','desc')->get();
    }

}