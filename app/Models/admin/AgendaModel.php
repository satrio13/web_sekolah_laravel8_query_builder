<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class AgendaModel
{
    protected $table = 'tb_agenda';

    function list_agenda()
    {
        return DB::table($this->table)->orderBy('id','desc')->get();
    }

    function cek_agenda($id)
    {
        return DB::table($this->table)->select('id', 'gambar')->where('id', $id)->first();
    }

    function get_agenda($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_agenda($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_agenda($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_agenda($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}