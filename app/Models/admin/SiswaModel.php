<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class SiswaModel
{
    protected $table = 'tb_siswa';

    function list_siswa()
    {
        return DB::table('tb_siswa')->select('tb_siswa.*','tb_tahun.tahun')->join('tb_tahun','tb_siswa.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_siswa.id','desc')->get();
    }

    function cek_siswa($id)
    {
        return DB::table($this->table)->select('id')->find($id);
    }

    function get_siswa($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_siswa($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_siswa($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_siswa($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}