<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ProfilModel
{
    function get_profil()
    {
        return DB::table('tb_profil')->where('id', 1)->first();
    }

    function get_sejarah()
    {
        return DB::table('tb_sejarah')->where('id', 1)->first();
    }

    function get_visi_misi()
    {
        return DB::table('tb_visimisi')->where('id', 1)->first();
    }

    function get_struktur_organisasi()
    {
        return DB::table('tb_struktur_organisasi')->where('id', 1)->first();
    }

    function get_sarpras()
    {
        return DB::table('tb_sarpras')->where('id', 1)->first();
    }

    function list_ekstrakurikuler()
    {
        return DB::table('tb_ekstrakurikuler')->orderBy('nama_ekstrakurikuler','asc')->get();
    }

    function cek_ekstrakurikuler($slug)
    {
        return DB::table('tb_ekstrakurikuler')->select('slug')->where('slug', $slug)->first();
    }

    function get_ekstrakurikuler($slug)
    {
        return DB::table('tb_ekstrakurikuler')->where('slug', $slug)->first();
    }

}