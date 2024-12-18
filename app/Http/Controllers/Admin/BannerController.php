<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BannerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    function __construct()
    {
        $this->banner_model = new BannerModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Banner';
        $data['data'] = $this->banner_model->list_banner();
        return view('admin.banner.index', $data);
    }

    function tambah_banner()
    {     
        $data['title'] = 'Tambah Banner';
        return view('admin.banner.form_tambah', $data);
    }

    function simpan_banner(Request $request)
    {   
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            'judul' => 'max:100',
            'keterangan' => 'max:200',
            'button' => 'max:30',
            'link' => 'nullable|url|max:300',
            'is_active' => 'required'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {            
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/banner'), $nama_gambar);
        }
        
        $data = [
            'gambar' => $nama_gambar,
            'judul' => $request->input('judul'),
            'keterangan' => $request->input('keterangan'),
            'link' => $request->input('link'),
            'button' => $request->input('button'),
            'is_active' => $request->input('is_active'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->banner_model->simpan_banner($data);
        return redirect()->route('backend/banner')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_banner($id)
    {
        $cek = $this->banner_model->cek_banner($id);
        if($cek)
        {   
            $data['title'] = 'Edit Banner';
            $data['data'] = $this->banner_model->get_banner($id);
            return view('admin.banner.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_banner(Request $request, $id)
    {   
        $request->validate([
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024',
            'judul' => 'max:100',
            'keterangan' => 'max:200',
            'button' => 'max:30',
            'link' => 'nullable|url|max:300',
            'is_active' => 'required'
        ]);
            
        $get = $this->banner_model->cek_banner($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {   
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/banner'), $nama_gambar);
            if(File::exists("img/banner/$get->gambar"))
            {
                File::delete("img/banner/$get->gambar");
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'gambar' => $nama_gambar,
            'judul' => $request->input('judul'),
            'keterangan' => $request->input('keterangan'),
            'link' => $request->input('link'),
            'button' => $request->input('button'),
            'is_active' => $request->input('is_active'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->banner_model->update_banner($data, $id);
        return redirect()->route('backend/banner')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_banner($id)
    {
        $cek = $this->banner_model->cek_banner($id);
        if($cek)
        {   
            if(File::exists("img/banner/$cek->gambar"))
            {
                File::delete("img/banner/$cek->gambar");
            }

            $this->banner_model->hapus_banner($id);
            return redirect()->route('backend/banner')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    } 

}