<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProfilModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{
    function __construct()
    {
        $this->profil_model = new ProfilModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Profil Website';
        $data['data'] = $this->profil_model->get_profil('*');
        return view('admin.profil.index', $data);
    }

    function edit_profil_web()
    {
        $data['title'] = 'Edit Profil Website';
        $data['data'] = $this->profil_model->get_profil('*');
        return view('admin.profil.form_profil', $data);
    }

    function update_profil_web(Request $request)
    {
        $request->validate([
            'nama_web' => 'required|max:100',
            'jenjang' => 'required|numeric',
            'meta_description' => 'required|max:300',
            'meta_keyword' => 'required|max:200',
            'alamat' => 'required|max:300',
            'email' => 'required|email|max:100',
            'telp' => 'required|max:20',
            'fax' => 'required|max:20',
            'whatsapp' => 'max:20',
            'akreditasi' => 'max:5',
            'kurikulum' => 'required|max:30',
            'nama_kepsek' => 'required|max:100',
            'nama_operator' => 'required|max:100',
            'instagram' => 'nullable|url|max:200',
            'facebook' => 'nullable|url|max:200',
            'twitter' => 'nullable|url|max:200',
            'youtube' => 'nullable|url|max:200'
        ]);
        
        $data = [
            'nama_web' => $request->input('nama_web'),
            'jenjang' => $request->input('jenjang'),
            'meta_description' => $request->input('meta_description'),
            'meta_keyword' => $request->input('meta_keyword'),
            'profil' => $request->input('profil'),
            'alamat' => $request->input('alamat'),
            'email' => $request->input('email'),
            'telp' => $request->input('telp'),
            'fax' => $request->input('fax'),
            'whatsapp' => $request->input('whatsapp'),
            'akreditasi' => $request->input('akreditasi'),
            'kurikulum' => $request->input('kurikulum'),
            'nama_kepsek' => $request->input('nama_kepsek'),
            'nama_operator' => $request->input('nama_operator'),
            'instagram' => $request->input('instagram'),
            'facebook' => $request->input('facebook'),
            'twitter' => $request->input('twitter'),
            'youtube' => $request->input('youtube'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->profil_model->update_profil($data);
        return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function logo_web()
    {
        $data['title'] = 'Edit Logo Website';
        $data['data'] = $this->profil_model->get_profil('logo_web');
        return view('admin.profil.form_logo_web', $data);
    }

    function update_logo_web(Request $request)
    {
        $request->validate([
            'logo_web' => 'required|image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $get = $this->profil_model->get_profil('logo_web');
        if($request->hasFile('logo_web') AND $request->file('logo_web')->isValid()) 
        {
            $gambar = $request->file('logo_web');
            $nama_gambar = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('img/logo'), $nama_gambar);
            if(File::exists("img/logo/$get->logo_web"))
            {
                File::delete("img/logo/$get->logo_web");
            }
        }   

        $data = ['logo_web' => $nama_gambar];
        $this->profil_model->update_profil($data);
        return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function favicon()
    {
        $data['title'] = 'Edit Favicon';
        $data['data'] = $this->profil_model->get_profil('favicon');
        return view('admin.profil.form_favicon', $data);
    }

    function update_favicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|max:100'
        ]);
        
        $get = $this->profil_model->get_profil('favicon');
        if($request->hasFile('favicon') AND $request->file('favicon')->isValid()) 
        {
            $gambar = $request->file('favicon');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/logo'), $nama_gambar);
            if(File::exists("img/logo/$get->favicon"))
            {
                File::delete("img/logo/$get->favicon");
            }               
        }

        $data = ['favicon' => $nama_gambar];
        $this->profil_model->update_profil($data);
        return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function logo_admin()
    {
        $data['title'] = 'Edit Logo Login Admin';
        $data['data'] = $this->profil_model->get_profil('logo_admin');
        return view('admin.profil.form_logo_admin', $data);
    }

    function update_logo_admin(Request $request)
    {
        $request->validate([
            'logo_admin' => 'required|image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $get = $this->profil_model->get_profil('logo_admin');
        if($request->hasFile('logo_admin') AND $request->file('logo_admin')->isValid()) 
        {
            $gambar = $request->file('logo_admin');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/logo'), $nama_gambar);
            if(File::exists("img/logo/$get->logo_admin"))
            {
                File::delete("img/logo/$get->logo_admin");
            }
        }

        $data = ['logo_admin' => $nama_gambar];
        $this->profil_model->update_profil($data);
        return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function gambar_profil()
    {
        $data['title'] = 'Edit Gambar Profil';
        $data['data'] = $this->profil_model->get_profil('gambar');
        return view('admin.profil.form_gambar_profil', $data);
    }

    function update_gambar_profil(Request $request)
    {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        
        $nama_gambar = '';
        $get = $this->profil_model->get_profil('gambar');
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('img/profil'), $nama_gambar);
            if(File::exists("img/profil/$get->gambar"))
            {
                File::delete("img/profil/$get->gambar");
            }
        }

        $data = ['gambar' => $nama_gambar];
        $this->profil_model->update_profil($data);
        return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function file()
    {
        $data['title'] = 'Edit File';
        $data['data'] = $this->profil_model->get_profil('file');
        return view('admin.profil.form_file', $data);
    }

    function update_file(Request $request)
    {
        $request->validate([
            'file' => 'mimes:pdf|max:5120'
        ]);
        
        $nama_file = '';
        $get = $this->profil_model->get_profil('file');
        if($request->hasFile('file') AND $request->file('file')->isValid()) 
        {
            $file = $request->file('file');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('file'), $nama_file);
            if(File::exists("file/$get->file"))
            {
                File::delete("file/$get->file");
            }    
        }

        $data = ['file' => $nama_file];
        $this->profil_model->update_profil($data);
        return redirect()->route('backend/profil-web')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}