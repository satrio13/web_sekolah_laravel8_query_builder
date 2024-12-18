<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class PrestasiSekolahModel
{
    protected $table = 'tb_prestasi_sekolah';

    function list_prestasi_sekolah()
    {
        return DB::table('tb_prestasi_sekolah')->select('tb_prestasi_sekolah.*','tb_tahun.tahun')->join('tb_tahun','tb_prestasi_sekolah.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_prestasi_sekolah.id','desc')->get();
    }

    function cek_prestasi_sekolah($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->find($id);
    }

    function get_prestasi_sekolah($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_prestasi_sekolah($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_prestasi_sekolah($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_prestasi_sekolah($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }
    
}