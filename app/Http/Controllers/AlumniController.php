<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AlumniModel;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    function __construct()
    {
        $this->alumni_model = new AlumniModel();
    }

    function index()
    {     
        $data['titleweb'] = 'Alumni - '.title();
		$data['title'] = 'Alumni';
        $data['data'] = $this->alumni_model->list_alumni();
        return view('alumni/index', $data);
    }

    function penelusuran_alumni()
    {     
        $data['titleweb'] = 'Penelusuran Alumni - '.title();
		$data['title'] = 'Penelusuran Alumni';
        $data['data'] = $this->alumni_model->list_isialumni();
        return view('alumni/penelusuran', $data);
    }

    function simpan_penelusuran_alumni(Request $request)
    {     
        $request->validate([
            'nama' => 'required|max:100',
            'th_lulus' => 'required|min:4|max:4',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/alumni'), $nama_gambar);
        }
        
        $data = [
            'nama' => $request->input('nama'),
            'th_lulus' => $request->input('th_lulus'),
            'sma' => $request->input('sma'),
            'pt' => $request->input('pt'),
            'instansi' => $request->input('instansi'),
            'alamatins' => $request->input('alamatins'),
            'hp' => $request->input('hp'),
            'email' => $request->input('email'),
            'alamat' => $request->input('alamat'),
            'kesan' => $request->input('kesan'),
            'gambar' => $nama_gambar,
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->alumni_model->simpan_penelusuran_alumni($data);
        return redirect()->route('alumni/penelusuran-alumni')->with(['success' => 'Data Berhasil Disimpan!']);
    }

}