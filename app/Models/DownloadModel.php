<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class DownloadModel
{
    protected $table = 'tb_download';

    function list_download()
    {
        return DB::table($this->table)->where('is_active',1)->orderBy('created_at','desc')->get();
    }

    function cek_download($file)
    {
        return DB::table($this->table)->select('hits', 'file')->where('file', $file)->first();
    }

    function update_dibaca($data, $file)
    {
        return DB::table($this->table)->where('file', $file)->update($data);
    }

}