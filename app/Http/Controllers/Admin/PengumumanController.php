<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PengumumanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PengumumanController extends Controller
{
    function __construct()
    {
        $this->pengumuman_model = new PengumumanModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Pengumuman';
        $data['data'] = $this->pengumuman_model->list_pengumuman();
        return view('admin.pengumuman.index', $data);
    }

    function tambah_pengumuman()
    {     
        $data['title'] = 'Tambah Pengumuman';
        return view('admin.pengumuman.form_tambah', $data);
    }

    function simpan_pengumuman(Request $request)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'isi' => 'required',
            'is_active' => 'required',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama pengumuman harus diisi.',
            'nama.max:100' => 'Kolom nama pengumuman harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/pengumuman'), $nama_gambar);
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

        $this->pengumuman_model->simpan_pengumuman($data);
        return redirect()->route('backend/pengumuman')->with(['success' => 'Data Berhasil Disimpan!']); 
    }

    function edit_pengumuman($id)
    {
        $cek = $this->pengumuman_model->cek_pengumuman($id);
        if($cek)
        {   
            $data['title'] = 'Edit Pengumuman';
            $data['data'] = $this->pengumuman_model->get_pengumuman($id);
            return view('admin.pengumuman.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_pengumuman(Request $request, $id)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'isi' => 'required',
            'is_active' => 'required',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama pengumuman harus diisi.',
            'nama.max:100' => 'Kolom nama pengumuman harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $get = $this->pengumuman_model->cek_pengumuman($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/pengumuman'), $nama_gambar);
            if(File::exists("img/pengumuman/$get->gambar"))
            {
                File::delete("img/pengumuman/$get->gambar");
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

        $this->pengumuman_model->update_pengumuman($data, $id);
        return redirect()->route('backend/pengumuman')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_pengumuman($id)
    {
        $cek = $this->pengumuman_model->cek_pengumuman($id);
        if($cek)
        {   
            if(File::exists("img/pengumuman/$cek->gambar"))
            {
                File::delete("img/pengumuman/$cek->gambar");
            }

            $this->pengumuman_model->hapus_pengumuman($id);
            return redirect()->route('backend/pengumuman')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }  

}