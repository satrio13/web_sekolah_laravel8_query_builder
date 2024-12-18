<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class BeritaModel
{
    protected $table = 'tb_berita';

    function list_berita()
    {
        return DB::table('tb_berita')->select('tb_berita.*', 'tb_user.nama as nama_operator')->join('tb_user','tb_berita.id_user', '=', 'tb_user.id_user')->orderBy('tb_berita.id','desc')->get();
    }

    function cek_berita($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->where('id', $id)->first();
    }

    function get_berita($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_berita($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_berita($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_berita($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}