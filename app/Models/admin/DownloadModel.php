<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class DownloadModel
{
    protected $table = 'tb_download';

    function list_download()
    {
        return DB::table('tb_download')->select('tb_download.*', 'tb_user.nama')->join('tb_user','tb_download.id_user', '=', 'tb_user.id_user')->orderBy('tb_download.id','desc')->get();
    }

    function cek_download($id)
    {
        return DB::table($this->table)->select('id', 'file')->where('id', $id)->first();
    }

    function get_download($id)
    {
        return DB::table($this->table)->find($id);
    }

    function simpan_download($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_download($data, $id)
    {
        return DB::table($this->table)->where('id', $id)->update($data);
    }

    function hapus_download($id)
    {
        return DB::table($this->table)->where('id', $id)->delete();
    }

}