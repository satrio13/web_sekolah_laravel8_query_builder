<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class VideoModel
{
    protected $table = 'tb_video';

    function list_video($page)
    {
        return DB::table($this->table)->orderBy('updated_at','desc')->paginate($page);
    }

}