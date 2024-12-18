<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class PengaduanModel
{
    protected $table = 'tb_pengaduan';

    function simpan_pengaduan($data)
    {
        return DB::table($this->table)->insert($data);
    }

}