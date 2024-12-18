<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\BeritaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    function __construct()
    {
        $this->berita_model = new BeritaModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Berita';
        $data['data'] = $this->berita_model->list_berita();
        return view('admin.berita.index', $data);
    }

    function tambah_berita()
    {     
        $data['title'] = 'Tambah Berita';
        return view('admin.berita.form_tambah', $data);
    }

    function simpan_berita(Request $request)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'isi' => 'required',
            'is_active' => 'required',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama berita harus diisi.',
            'nama.max:100' => 'Kolom nama berita harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/berita'), $nama_gambar);
        }
        
        $data = [
            'nama' => $request->input('nama'),
            'isi' => $request->input('isi'),
            'gambar' => $nama_gambar,
            'dibaca' => 0,
            'id_user' => session('id_user'),
            'is_active' => $request->input('is_active'),
            'hari' => hari_ini_indo(),
            'tgl' => tgl_jam_simpan_sekarang(),
            'slug' => Str::slug($request->input('nama'), '-'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->berita_model->simpan_berita($data);
        return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_berita($id)
    {
        $cek = $this->berita_model->cek_berita($id);
        if($cek)
        {   
            $data['title'] = 'Edit Berita';
            $data['data'] = $this->berita_model->get_berita($id);
            return view('admin.berita.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_berita(Request $request, $id)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'isi' => 'required',
            'is_active' => 'required',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama berita harus diisi.',
            'nama.max:100' => 'Kolom nama berita harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $get = $this->berita_model->cek_berita($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/berita'), $nama_gambar);
            if(File::exists("img/berita/$get->gambar"))
            {
                File::delete("img/berita/$get->gambar");
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'nama' => $request->input('nama'),
            'isi' => $request->input('isi'),
            'gambar' => $nama_gambar,
            'id_user' => session('id_user'),
            'is_active' => $request->input('is_active'),
            'slug' => Str::slug($request->input('nama'), '-'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->berita_model->update_berita($data, $id);
        return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_berita($id)
    {
        $cek = $this->berita_model->cek_berita($id);
        if($cek)
        {   
            if(File::exists("img/berita/$cek->gambar"))
            {
                File::delete("img/berita/$cek->gambar");
            }

            $this->berita_model->hapus_berita($id);
            return redirect()->route('backend/berita')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }  

}