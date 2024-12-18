<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KaryawanModel;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    function __construct()
    {
        $this->karyawan_model = new KaryawanModel();
    }

    function index()
    {     
        $data['titleweb'] = 'Karyawan - '.title();
		$data['title'] = 'Karyawan';
        $data['data'] = $this->karyawan_model->list_karyawan();
        return view('karyawan.index', $data);
    }

    function detail($id)
    {
        $cek = $this->karyawan_model->cek_karyawan($id);
        if($cek)
        {   
            $data['titleweb'] = 'Detail Karyawan - '.title();
            $data['title'] = 'Detail Karyawan';
            $data['data'] = $this->karyawan_model->get_karyawan($id);
            return view('karyawan/detail', $data);
        }else
        {
            abort(404);
        }
    }

}