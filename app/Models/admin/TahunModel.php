<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class TahunModel
{
    protected $table = 'tb_tahun';

    function list_tahun()
    {
        return DB::table($this->table)->orderBy('id_tahun','desc')->get();
    }

    function cek_tahun($id)
    {
        return DB::table($this->table)->select('id_tahun')->where('id_tahun', $id)->first();
    }

    function get_tahun($id)
    {
        return DB::table($this->table)->where('id_tahun', $id)->first();
    }

    function simpan_tahun($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_tahun($data, $id)
    {
        return DB::table($this->table)->where('id_tahun', $id)->update($data);
    }

    function hapus_tahun($id)
    {
        return DB::table($this->table)->where('id_tahun', $id)->delete();
    }

    function cek_tahun_rekap_un($id)
    {
        return DB::table('tb_rekap_un')->select('id_tahun')->where('id_tahun', $id)->first();
    }

    function cek_tahun_rekap_us($id)
    {
        return DB::table('tb_rekap_us')->select('id_tahun')->where('id_tahun', $id)->first();
    }

    function cek_tahun_siswa($id)
    {
        return DB::table('tb_siswa')->select('id_tahun')->where('id_tahun', $id)->first();
    }

    function cek_tahun_prestasi_siswa($id)
    {
        return DB::table('tb_prestasi_siswa')->select('id_tahun')->where('id_tahun', $id)->first();
    }

    function cek_tahun_prestasi_guru($id)
    {
        return DB::table('tb_prestasi_guru')->select('id_tahun')->where('id_tahun', $id)->first();
    }

    function cek_tahun_prestasi_sekolah($id)
    {
        return DB::table('tb_prestasi_sekolah')->select('id_tahun')->where('id_tahun', $id)->first();
    }

    function cek_tahun_alumni($id)
    {
        return DB::table('tb_alumni')->select('id_tahun')->where('id_tahun', $id)->first();
    }

}