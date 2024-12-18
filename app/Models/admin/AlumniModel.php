<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class AlumniModel
{
    protected $table = 'tb_alumni';

    function list_alumni()
    {
        return DB::table('tb_alumni')->select('tb_alumni.*', 'tb_tahun.tahun')->join('tb_tahun','tb_alumni.id_tahun', '=', 'tb_tahun.id_tahun')->orderBy('tb_alumni.id','desc')->get();
    }

    function cek_alumni($id)
    {
        return DB::table($this->table)->select('id')->where('id', $id)->first();
    }

    function get_alumni($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_alumni($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_alumni($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_alumni($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

    function list_isialumni()
    {
        return DB::table('tb_isialumni')->orderBy('id','desc')->get();
    }

    function cek_isialumni($id)
    {
        return DB::table('tb_isialumni')->select('id', 'gambar')->where('id', $id)->first();
    }

    function get_isialumni($id)
    {
        return DB::table('tb_isialumni')->find($id);
    }

    function update_isialumni($data, $id)
    {
        return DB::table('tb_isialumni')->where('id', $id)->update($data);
    }

    function hapus_isialumni($id)
    {
        return DB::table('tb_isialumni')->where('id', $id)->delete();
    }

}