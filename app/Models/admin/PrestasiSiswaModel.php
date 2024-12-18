<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class PrestasiSiswaModel
{
    protected $table = 'tb_prestasi_siswa';

    function list_prestasi_siswa()
    {
        return DB::table('tb_prestasi_siswa')->select('tb_prestasi_siswa.*','tb_tahun.tahun')->join('tb_tahun','tb_prestasi_siswa.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_prestasi_siswa.id','desc')->get();
    }

    function cek_prestasi_siswa($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->find($id);
    }

    function get_prestasi_siswa($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_prestasi_siswa($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_prestasi_siswa($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_prestasi_siswa($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}