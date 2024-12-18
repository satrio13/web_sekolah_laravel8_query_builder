<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PendidikanModel;
use App\Models\Admin\TahunModel;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
    function __construct()
    {
        $this->pendidikan_model = new PendidikanModel();
        $this->tahun_model = new TahunModel();
    }

    function kurikulum()
    {     
        $data['titleweb'] = 'Kurikulum - '.title();
		$data['title'] = 'Kurikulum';
        $data['kelompok_a'] = $this->pendidikan_model->list_kurikulum_a();
        $data['kelompok_b'] = $this->pendidikan_model->list_kurikulum_b();
        $data['kelompok_c'] = $this->pendidikan_model->list_kurikulum_c();
        return view('pendidikan/kurikulum', $data);
    }

    function kalender()
    {     
        $data['titleweb'] = 'Kalender Akademik - '.title();
		$data['title'] = 'Kalender Akademik';
        $data['data'] = $this->pendidikan_model->get_kalender();
        return view('pendidikan/kalender', $data);
    }

    function rekap_us(Request $request)
    {     
        if(jenjang() == 1 OR jenjang() == 2)
        { 
            $jenis = 'Sekolah';
        }else
        {
            $jenis = 'Madrasah';
        }
        
        $data['titleweb'] = "Rekap Ujian $jenis - ".title();
        $data['title'] = "Rekap Ujian $jenis";
        $data['tahun'] = $this->tahun_model->list_tahun();
        $data['submit'] = $request->input('submit');
        $data['id_tahun'] = $request->input('id_tahun');
        $data['data'] = $this->pendidikan_model->cari_rekap_us($request->input('id_tahun'));
        return view('pendidikan/rekap_us', $data);
    }

}