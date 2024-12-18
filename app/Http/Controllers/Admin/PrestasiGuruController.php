<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PrestasiGuruModel;
use App\Models\Admin\TahunModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrestasiGuruController extends Controller
{
    function __construct()
    {
        $this->prestasi_guru_model = new PrestasiGuruModel();
        $this->tahun_model = new TahunModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Prestasi Guru';
        $data['data'] = $this->prestasi_guru_model->list_prestasi_guru();
        return view('admin.prestasi_guru.index', $data);
    }

    function tambah_prestasi_guru()
    {     
        $data['title'] = 'Tambah Prestasi Guru';
        $data['tahun'] = $this->tahun_model->list_tahun();
        return view('admin.prestasi_guru.form_tambah', $data);
    }

    function simpan_prestasi_guru(Request $request)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'nama_guru' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama lomba harus diisi.',
            'nama.max:100' => 'Kolom nama lomba harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_guru'), $nama_gambar);
        }
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'nama' => $request->input('nama'),
            'prestasi' => $request->input('prestasi'),
            'nama_guru' => $request->input('nama_guru'),
            'tingkat' => $request->input('tingkat'),
            'jenis' => $request->input('jenis'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $nama_gambar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->prestasi_guru_model->simpan_prestasi_guru($data);
        return redirect()->route('backend/prestasi-guru')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_prestasi_guru($id)
    {   
        $cek = $this->prestasi_guru_model->cek_prestasi_guru($id);
        if($cek)
        {
            $data['title'] = 'Edit Prestasi Guru';
            $data['data'] = $this->prestasi_guru_model->get_prestasi_guru($id);
            $data['tahun'] = $this->tahun_model->list_tahun();
            return view('admin.prestasi_guru.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_prestasi_guru(Request $request, $id)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'nama_guru' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama lomba harus diisi.',
            'nama.max:100' => 'Kolom nama lomba harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $get = $this->prestasi_guru_model->cek_prestasi_guru($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_guru'), $nama_gambar);
            if(File::exists("img/prestasi_guru/$get->gambar"))
            {
                File::delete("img/prestasi_guru/$get->gambar");
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'nama' => $request->input('nama'),
            'prestasi' => $request->input('prestasi'),
            'nama_guru' => $request->input('nama_guru'),
            'tingkat' => $request->input('tingkat'),
            'jenis' => $request->input('jenis'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->prestasi_guru_model->update_prestasi_guru($data, $id);
        return redirect()->route('backend/prestasi-guru')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_prestasi_guru($id)
    {   
        $cek = $this->prestasi_guru_model->cek_prestasi_guru($id);
        if($cek)
        {
            if(File::exists("img/prestasi_guru/$cek->gambar"))
            {
                File::delete("img/prestasi_guru/$cek->gambar");
            }
            
            $this->prestasi_guru_model->hapus_prestasi_guru($id);
            return redirect()->route('backend/prestasi-guru')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }

}