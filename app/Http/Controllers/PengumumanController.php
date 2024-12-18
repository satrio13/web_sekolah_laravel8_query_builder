<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PengumumanModel;
use App\Models\HomeModel;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    function __construct()
    {
        $this->pengumuman_model = new PengumumanModel();
        $this->home_model = new HomeModel();
    }

    function index(Request $request)
    {     
        $data['titleweb'] = 'Pengumuman - '.title();
		$data['title'] = 'Pengumuman';
        
        $keyword = $request->input('q');
        if($keyword)
        {
            $data['data'] = $this->pengumuman_model->list_pengumuman_cari(8, $keyword);
        }else
        {
            $data['data'] = $this->pengumuman_model->list_Pengumuman(8);
        }
        
        $data['cari'] = $keyword;
        return view('pengumuman.index', $data);
    }

    function detail($slug)
    {
        $cek = $this->pengumuman_model->cek_pengumuman($slug);
        if($cek)
        {
            $get = $this->pengumuman_model->get_pengumuman($slug);
            $data['titleweb'] = $get->nama.' - '.title();
            $data['title'] = $get->nama;

            $upd = ['dibaca' => $cek->dibaca + 1];
            $this->pengumuman_model->update_dibaca($upd, $slug);

            $data['data'] = $get;
            $data['berita_populer'] = $this->home_model->berita_populer($slug);
            $data['link_terkait'] = $this->home_model->link_terkait();
            return view('pengumuman.detail', $data);
        }else
        {
            abort(404);
        }     
    }

}