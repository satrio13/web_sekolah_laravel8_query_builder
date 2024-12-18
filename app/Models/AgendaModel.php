<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class AgendaModel
{
    protected $table = 'tb_agenda';

    function list_agenda($page)
    {
        return DB::table('tb_agenda')->orderBy('id','desc')->paginate($page);
    }

    function list_agenda_cari($page, $keyword)
    {
        return DB::table('tb_agenda')->where('nama_agenda', 'like', '%'.$keyword.'%')->orderBy('id','desc')->paginate($page);
    }

    function cek_agenda($slug)
    {
        return DB::table($this->table)->select('slug')->where('slug', $slug)->first();
    }

    function get_agenda($slug)
    {
        return DB::table($this->table)->where('slug', $slug)->first();
    }

}