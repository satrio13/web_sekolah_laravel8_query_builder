<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class RekapUSModel
{
    protected $table = 'tb_rekap_us';

    function list_rekap_us()
    {
        return DB::table('tb_rekap_us')->select('tb_rekap_us.*','tb_kurikulum.mapel','tb_tahun.tahun')->join('tb_kurikulum','tb_rekap_us.id_kurikulum', '=', 'tb_kurikulum.id_kurikulum')->join('tb_tahun','tb_rekap_us.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_rekap_us.id_us','desc')->get();
    }

    function cek_rekap_us($id)
    {
        return DB::table($this->table)->select('id_us')->where('id_us', $id)->first();
    }

    function get_rekap_us($id)
    {
        return DB::table($this->table)->where('id_us', $id)->first();
    }

    function simpan_rekap_us($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_rekap_us($data, $id)
    {
        return DB::table($this->table)->where('id_us', $id)->update($data);
    }

    function hapus_rekap_us($id)
    {
        return DB::table($this->table)->where('id_us', $id)->delete();
    }

    function list_tahun()
    {
        return DB::table('tb_tahun')->orderBy('tahun','desc')->get();
    }

    function list_kurikulum()
    {
        return DB::table('tb_kurikulum')->orderBy('mapel','asc')->get();
    }

}