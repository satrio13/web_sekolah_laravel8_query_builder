<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class SejarahModel
{
    protected $table = 'tb_sejarah';

    function get_sejarah()
    {
        return DB::table($this->table)->where('id', 1)->first();
    }

    function update_sejarah($data)
    {
        return DB::table($this->table)->where('id', 1)->update($data);
    }

}