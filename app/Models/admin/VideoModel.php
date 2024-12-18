<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class VideoModel
{
    protected $table = 'tb_video';

    function list_video()
    {
        return DB::table($this->table)->orderBy('id_video','desc')->get();
    }

    function cek_video($id)
    {
        return DB::table($this->table)->select('id_video')->where('id_video', $id)->first();
    }

    function get_video($id)
    {
        return DB::table($this->table)->where('id_video', $id)->first();
    }

    function simpan_video($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_video($data, $id)
    {
        return DB::table($this->table)->where('id_video', $id)->update($data);
    }

    function hapus_video($id)
    {
        return DB::table($this->table)->where('id_video', $id)->delete();
    }

}