<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class LinkModel
{
    protected $table = 'tb_link';
    
    function list_link()
    {
        return DB::table($this->table)->orderBy('id','desc')->get();
    }

    function cek_link($id)
    {
        return DB::table($this->table)->select('id')->where('id', $id)->find($id);
    }

    function get_link($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_link($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_link($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_link($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}