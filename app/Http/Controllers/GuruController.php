<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GuruModel;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    function __construct()
    {
        $this->guru_model = new GuruModel();
    }

    function index()
    {     
        $data['titleweb'] = 'Guru - '.title();
		$data['title'] = 'Guru';
        $data['data'] = $this->guru_model->list_guru();
        return view('guru.index', $data);
    }

    function detail($id)
    {
        $cek = $this->guru_model->cek_guru($id);
        if($cek)
        {   
            $data['titleweb'] = 'Detail Guru - '.title();
            $data['title'] = 'Detail Guru';
            $data['data'] = $this->guru_model->get_guru($id);
            return view('guru/detail', $data);
        }else
        {
            abort(404);
        }
    }

}