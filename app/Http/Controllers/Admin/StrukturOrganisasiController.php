<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\StrukturOrganisasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StrukturOrganisasiController extends Controller
{
    function __construct()
    {
        $this->struktur_model = new StrukturOrganisasiModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Struktur Organisasi';
        $data['data'] = $this->struktur_model->get_struktur_organisasi();
        return view('admin.struktur_organisasi.index', $data);
    }

    function edit_struktur_organisasi()
    {     
        $data['title'] = 'Edit Struktur Organisasi';
        $data['data'] = $this->struktur_model->get_struktur_organisasi();
        return view('admin.struktur_organisasi.form_struktur_organisasi', $data);
    }

    function update_struktur_organisasi(Request $request)
    {   
        $request->validate([
            'struktur' => 'image|mimes:jpeg,jpg,png|max:3072|required'
        ]);
            
        $get = $this->struktur_model->get_struktur_organisasi();
        if($request->hasFile('struktur') AND $request->file('struktur')->isValid()) 
        {
            $gambar = $request->file('struktur');
            $nama_gambar = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('img/struktur'), $nama_gambar);
            if(File::exists("img/struktur/$get->isi"))
            {
                File::delete("img/struktur/$get->isi");
            }    
        }else
        {
            $nama_gambar = '';
        }
        
        $data = [
            'isi' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->struktur_model->update_struktur_organisasi($data);
        return redirect()->route('backend/struktur-organisasi')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}