<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AgendaModel;
use App\Models\HomeModel;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    function __construct()
    {
        $this->agenda_model = new AgendaModel();
        $this->home_model = new HomeModel();
    }

    function index(Request $request)
    {     
        $data['titleweb'] = 'Agenda - '.title();
		$data['title'] = 'Agenda';
        
        $keyword = $request->input('q');
        if($keyword)
        {
            $data['data'] = $this->agenda_model->list_agenda_cari(6, $keyword);
        }else
        {
            $data['data'] = $this->agenda_model->list_agenda(6);
        }
        
        $data['cari'] = $keyword;
        return view('agenda.index', $data);
    }

    function detail($slug)
    {
        $cek = $this->agenda_model->cek_agenda($slug);
        if($cek)
        {
            $get = $this->agenda_model->get_agenda($slug);
            $data['titleweb'] = $get->nama_agenda.' - '.title();
            $data['title'] = $get->nama_agenda;
            $data['data'] = $get;
            $data['berita_populer'] = $this->home_model->berita_populer($slug);
            $data['link_terkait'] = $this->home_model->link_terkait();
            return view('agenda.detail', $data);
        }else
        {
            abort(404);
        }     
    }

}