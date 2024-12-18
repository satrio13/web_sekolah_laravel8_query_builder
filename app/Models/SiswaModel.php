<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class SiswaModel
{
    function list_siswa()
    {
        return DB::table('tb_siswa')->select('tb_siswa.*', 'tb_tahun.tahun')->join('tb_tahun','tb_siswa.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_tahun.tahun','desc')->get();
    }

}