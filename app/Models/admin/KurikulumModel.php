<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class KurikulumModel
{
    protected $table = 'tb_kurikulum';

    function list_kurikulum()
    {
        return DB::table($this->table)->orderBy('id_kurikulum','desc')->get();
    }
    
    function list_kurikulum_order_by_mapel_asc()
    {
        return DB::table($this->table)->orderBy('mapel','asc')->get();
    }

    function cek_kurikulum($id)
    {
        return DB::table($this->table)->select('id_kurikulum')->where('id_kurikulum', $id)->first();
    }

    function get_kurikulum($id)
    {
        return DB::table($this->table)->where('id_kurikulum', $id)->first();
    }

    function simpan_kurikulum($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_kurikulum($data, $id)
    {
        return DB::table($this->table)->where('id_kurikulum', $id)->update($data);
    }

    function hapus_kurikulum($id)
    {
        return DB::table($this->table)->where('id_kurikulum', $id)->delete();
    }

    function cek_kurikulum_rekap_un($id)
    {
        return DB::table('tb_rekap_un')->select('id_kurikulum')->where('id_kurikulum', $id)->first();
    }

    function cek_kurikulum_rekap_us($id)
    {
        return DB::table('tb_rekap_us')->select('id_kurikulum')->where('id_kurikulum', $id)->first();
    }

}