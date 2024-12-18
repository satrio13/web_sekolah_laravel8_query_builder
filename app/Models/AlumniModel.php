<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class AlumniModel
{
    function list_isialumni()
    {
        return DB::table('tb_isialumni')->where('status', 1)->orderBy('updated_at','desc')->get();
    }

    function list_alumni()
    {
        return DB::table('tb_alumni')->select('tb_alumni.*', 'tb_tahun.tahun')->join('tb_tahun','tb_alumni.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_tahun.tahun','desc')->get();
    }

    function simpan_penelusuran_alumni($data)
    {
        return DB::table('tb_isialumni')->insert($data);
    }

}