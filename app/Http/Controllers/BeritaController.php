<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BeritaModel;
use App\Models\HomeModel;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    function __construct()
    {
        $this->berita_model = new BeritaModel();
        $this->home_model = new HomeModel();
    }

    function index(Request $request)
    {     
        $data['titleweb'] = 'Berita - '.title();
		$data['title'] = 'Berita';
        
        $keyword = $request->input('q');
        if($keyword)
        {
            $data['data'] = $this->berita_model->list_berita_cari(8, $keyword);
        }else
        {
            $data['data'] = $this->berita_model->list_berita(8);
        }
        
        $data['cari'] = $keyword;
        return view('berita.index', $data);
    }

    function detail($slug)
    {
        $cek = $this->berita_model->cek_berita($slug);
        if($cek)
        {
            $get = $this->berita_model->get_berita($slug);
            $data['titleweb'] = $get->nama.' - '.title();
            $data['title'] = $get->nama;
            
            $upd = ['dibaca' => $cek->dibaca + 1];
            $this->berita_model->update_dibaca($upd, $slug);

            $data['data'] = $get;
            $data['berita_populer'] = $this->home_model->berita_populer($slug);
            $data['link_terkait'] = $this->home_model->link_terkait();
            return view('berita.detail', $data);
        }else
        {
            abort(404);
        }     
    }

}