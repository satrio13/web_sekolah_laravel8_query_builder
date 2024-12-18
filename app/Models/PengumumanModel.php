<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class PengumumanModel
{
    protected $table = 'tb_pengumuman';

    function list_pengumuman($page)
    {
        return DB::table('tb_pengumuman')->where('is_active', 1)->orderBy('id','desc')->paginate($page);
    }

    function list_pengumuman_cari($page, $keyword)
    {
        return DB::table('tb_pengumuman')->where('is_active', 1)->where('nama', 'like', '%'.$keyword.'%')->orderBy('id','desc')->paginate($page);
    }

    function cek_pengumuman($slug)
    {
        return DB::table($this->table)->select('slug','dibaca')->where('slug', $slug)->first();
    }

    function get_pengumuman($slug)
    {
        return DB::table($this->table)->where('slug', $slug)->first();
    }

    function update_dibaca($data, $slug)
    {
        return DB::table($this->table)->where('slug', $slug)->update($data);
    }
    
}