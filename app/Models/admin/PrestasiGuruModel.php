<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class PrestasiGuruModel
{
    protected $table = 'tb_prestasi_guru';

    function list_prestasi_guru()
    {
        return DB::table('tb_prestasi_guru')->select('tb_prestasi_guru.*','tb_tahun.tahun')->join('tb_tahun','tb_prestasi_guru.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_prestasi_guru.id','desc')->get();
    }

    function cek_prestasi_guru($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->find($id);
    }

    function get_prestasi_guru($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_prestasi_guru($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_prestasi_guru($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_prestasi_guru($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}