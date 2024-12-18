<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class RekapUNModel
{
    protected $table = 'tb_rekap_un';

    function list_rekap_un()
    {
        return DB::table('tb_rekap_un')->select('tb_rekap_un.*','tb_kurikulum.mapel','tb_tahun.tahun')->join('tb_kurikulum','tb_rekap_un.id_kurikulum', '=', 'tb_kurikulum.id_kurikulum')->join('tb_tahun','tb_rekap_un.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_rekap_un.id_un','desc')->get();
    }

    function cek_rekap_un($id)
    {
        return DB::table($this->table)->select('id_un')->where('id_un', $id)->first();
    }

    function get_rekap_un($id)
    {
        return DB::table($this->table)->where('id_un', $id)->first();
    }

    function simpan_rekap_un($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_rekap_un($data, $id)
    {
        return DB::table($this->table)->where('id_un', $id)->update($data);
    }

    function hapus_rekap_un($id)
    {
        return DB::table($this->table)->where('id_un', $id)->delete();
    }
    
}