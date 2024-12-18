<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    function index()
    {     
        $data['titleweb'] = title();
        $data['banner'] = DB::table('tb_banner')->where('is_active', 1)->orderBy('id','desc')->get();
        $data['agenda'] = DB::table('tb_agenda')->orderBy('id','desc')->limit(3,0)->get();
        $data['pengumuman'] = DB::table('tb_pengumuman')->where('is_active', 1)->orderBy('id','desc')->limit(4,0)->get();
        $data['berita'] = DB::table('tb_berita')->where('is_active', 1)->orderBy('id','desc')->limit(4,0)->get();
        $data['download'] = DB::table('tb_download')->where('is_active', 1)->orderBy('id','desc')->limit(5,0)->get();
        $data['link'] = DB::table('tb_link')->where('is_active', 1)->orderBy('id','desc')->get();
        $data['ekstrakurikuler'] = DB::table('tb_ekstrakurikuler')->orderBy('id','desc')->limit(5,0)->get();
        $data['album'] = DB::table('tb_album')->where('is_active', 1)->orderBy('created_at','desc')->limit(2,0)->get();
        $data['video'] = DB::table('tb_video')->orderBy('created_at','desc')->limit(2,0)->get();
        $data['alumni'] = DB::table('tb_isialumni')->where('status', 1)->where('kesan', '!=', '')->where('gambar', '!=', '')->orderBy('id','desc')->limit(6,0)->get();
        return view('home', $data);
    }

}