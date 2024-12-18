<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class PengumumanModel
{
    protected $table = 'tb_pengumuman';

    function list_pengumuman()
    {
        return DB::table('tb_pengumuman')->select('tb_pengumuman.*', 'tb_user.nama as nama_operator')->join('tb_user','tb_pengumuman.id_user', '=', 'tb_user.id_user')->orderBy('tb_pengumuman.id','desc')->get();
    }

    function cek_pengumuman($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->where('id', $id)->first();
    }

    function get_pengumuman($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_pengumuman($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_pengumuman($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_pengumuman($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}