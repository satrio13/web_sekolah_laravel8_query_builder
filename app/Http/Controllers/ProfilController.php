<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProfilModel;
use App\Models\HomeModel;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    function __construct()
    {
        $this->profil_model = new ProfilModel();
        $this->home_model = new HomeModel();
    }

    function index()
    {     
        if(jenjang() == 1 OR jenjang() == 2)
        {
            $data['titleweb'] = 'Profil Sekolah - '.title();
            $data['title'] = 'Profil Sekolah';
        }else
        {
            $data['titleweb'] = 'Profil Madrasah - '.title();
            $data['title'] = 'Profil Madrasah';
        }
     
        $data['data'] = $this->profil_model->get_profil();
        return view('profil.index', $data);
    }

    function sejarah()
    {
        $data['titleweb'] = 'Sejarah - '.title();
        $data['title'] = 'Sejarah';
        $data['data'] = $this->profil_model->get_sejarah();
        return view('profil/sejarah', $data);
    }

    function visi_misi()
    {
        $data['titleweb'] = 'Visi & Misi - '.title();
        $data['title'] = 'Visi & Misi';
        $data['data'] = $this->profil_model->get_visi_misi();
        return view('profil/visi_misi', $data);
    }

    function struktur_organisasi()
    {
        $data['titleweb'] = 'Struktur Organisasi - '.title();
        $data['title'] = 'Struktur Organisasi';
        $data['data'] = $this->profil_model->get_struktur_organisasi();
        return view('profil/struktur_organisasi', $data);
    }

    function sarpras()
    {
        $data['titleweb'] = 'Sarana & Prasarana - '.title();
        $data['title'] = 'Sarana & Prasarana';
        $data['data'] = $this->profil_model->get_sarpras();
        return view('profil/sarpras', $data);
    }

    function ekstrakurikuler()
    {
        $data['titleweb'] = 'Ekstrakurikuler - '.title();
        $data['title'] = 'Ekstrakurikuler';
        $data['data'] = $this->profil_model->list_ekstrakurikuler();
        return view('profil/ekstrakurikuler', $data);
    }

    function detail_ekstrakurikuler($slug)
    {
        $cek = $this->profil_model->cek_ekstrakurikuler($slug);
        if($cek)
        {   
            $get = $this->profil_model->get_ekstrakurikuler($slug);
            $data['titleweb'] = $get->nama_ekstrakurikuler.' - '.title();
            $data['title'] = $get->nama_ekstrakurikuler;
            $data['data'] = $get;
            $data['berita_populer'] = $this->home_model->berita_populer($slug);
            $data['link_terkait'] = $this->home_model->link_terkait();
            return view('profil/detail_ekstrakurikuler', $data);
        }else
        {
            abort(404);
        }
    }

}