<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class PendidikanModel
{
    function list_kurikulum_a()
    {
        return DB::table('tb_kurikulum')->where('is_active', 1)->where('kelompok', 'A')->orderBy('no_urut','asc')->get(); 
    }

    function list_kurikulum_b()
    {
        return DB::table('tb_kurikulum')->where('is_active', 1)->where('kelompok', 'B')->orderBy('no_urut','asc')->get(); 
    }

    function list_kurikulum_c()
    {
        return DB::table('tb_kurikulum')->where('is_active', 1)->where('kelompok', 'C')->orderBy('no_urut','asc')->get();
    }

    function get_kalender()
    {
        return DB::table('tb_kalender')->where('id', 1)->first();
    }

    function cari_rekap_us($id_tahun)
    {
        return DB::table('tb_rekap_us')->select('tb_rekap_us.*', 'tb_kurikulum.mapel', 'tb_kurikulum.is_active', 'tb_tahun.tahun')->join('tb_kurikulum','tb_rekap_us.id_kurikulum', '=', 'tb_kurikulum.id_kurikulum')->join('tb_tahun','tb_rekap_us.id_tahun', '=', 'tb_tahun.id_tahun')->where('tb_rekap_us.id_tahun', $id_tahun)->orderBy('tb_kurikulum.mapel','asc')->get();
    }

}