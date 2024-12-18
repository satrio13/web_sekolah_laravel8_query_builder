<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class PrestasiModel
{
    function list_prestasi_siswa()
    {
        return DB::table('tb_prestasi_siswa')->select('tb_prestasi_siswa.*', 'tb_tahun.tahun')->join('tb_tahun','tb_prestasi_siswa.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_prestasi_siswa.id','desc')->get();
    }

    function list_prestasi_guru()
    {
        return DB::table('tb_prestasi_guru')->select('tb_prestasi_guru.*', 'tb_tahun.tahun')->join('tb_tahun','tb_prestasi_guru.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_prestasi_guru.id','desc')->get();
    }

    function list_prestasi_sekolah()
    {
        return DB::table('tb_prestasi_sekolah')->select('tb_prestasi_sekolah.*', 'tb_tahun.tahun')->join('tb_tahun','tb_prestasi_sekolah.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_prestasi_sekolah.id','desc')->get();
    }

}