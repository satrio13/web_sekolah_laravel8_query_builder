<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;

class UserModel
{
    protected $table = 'tb_user';

    function list_user()
    {
        return DB::table($this->table)->orderBy('id_user','desc')->get();
    }

    function cek_user($id)
    {
        return DB::table($this->table)->select('id_user','level')->where('id_user', $id)->first();
    }

    function get_user($id)
    {
        return DB::table($this->table)->where('id_user', $id)->first();
    }

    function simpan_user($data)
    {
        return DB::table($this->table)->insert($data);
    }

    function update_user($data, $id)
    {
        return DB::table($this->table)->where('id_user', $id)->update($data);
    }

    function hapus_user($id)
    {
        return DB::table($this->table)->where('id_user', $id)->delete();
    }

    function cek_username($id, $username)
    {
        return DB::table($this->table)->where('username', $username)->where('id_user', '!=', $id)->count();
    }

    function cek_email($id, $email)
    {
        return DB::table($this->table)->where('email', $email)->where('id_user', '!=', $id)->count();
    }

    function cek_user_pengumuman($id)
    {
        return DB::table('tb_pengumuman')->select('id_user')->where('id_user', $id)->first();
    }

    function cek_user_berita($id)
    {
        return DB::table('tb_berita')->select('id_user')->where('id_user', $id)->first();
    }

    function cek_user_download($id)
    {
        return DB::table('tb_download')->select('id_user')->where('id_user', $id)->first();
    }

}