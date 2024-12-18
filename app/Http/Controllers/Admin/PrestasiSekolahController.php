<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PrestasiSekolahModel;
use App\Models\Admin\TahunModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrestasiSekolahController extends Controller
{
    function __construct()
    {
        $this->prestasi_sekolah_model = new PrestasiSekolahModel();
        $this->tahun_model = new TahunModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Prestasi Sekolah';
        $data['data'] = $this->prestasi_sekolah_model->list_prestasi_sekolah();
        return view('admin.prestasi_sekolah.index', $data);
    }

    function tambah_prestasi_sekolah()
    {     
        $data['title'] = 'Tambah Prestasi Sekolah';
        $data['tahun'] = $this->tahun_model->list_tahun();
        return view('admin.prestasi_sekolah.form_tambah', $data);
    }

    function simpan_prestasi_sekolah(Request $request)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
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
            $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
        }
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'nama' => $request->input('nama'),
            'prestasi' => $request->input('prestasi'),
            'tingkat' => $request->input('tingkat'),
            'jenis' => $request->input('jenis'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $nama_gambar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->prestasi_sekolah_model->simpan_prestasi_sekolah($data);
        return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_prestasi_sekolah($id)
    {   
        $cek = $this->prestasi_sekolah_model->cek_prestasi_sekolah($id);
        if($cek)
        {
            $data['title'] = 'Edit Prestasi Sekolah';
            $data['data'] = $this->prestasi_sekolah_model->get_prestasi_sekolah($id);
            $data['tahun'] = $this->tahun_model->list_tahun();
            return view('admin.prestasi_sekolah.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_prestasi_sekolah(Request $request, $id)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama lomba harus diisi.',
            'nama.max:100' => 'Kolom nama lomba harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $get = $this->prestasi_sekolah_model->cek_prestasi_sekolah($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_sekolah'), $nama_gambar);
            if(File::exists("img/prestasi_sekolah/$get->gambar"))
            {
                File::delete("img/prestasi_sekolah/$get->gambar");
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'nama' => $request->input('nama'),
            'prestasi' => $request->input('prestasi'),
            'tingkat' => $request->input('tingkat'),
            'jenis' => $request->input('jenis'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->prestasi_sekolah_model->update_prestasi_sekolah($data, $id);
        return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_prestasi_sekolah($id)
    {   
        $cek = $this->prestasi_sekolah_model->cek_prestasi_sekolah($id);
        if($cek)
        {
            if(File::exists("img/prestasi_sekolah/$cek->gambar"))
            {
                File::delete("img/prestasi_sekolah/$cek->gambar");
            }

            $this->prestasi_sekolah_model->hapus_prestasi_sekolah($id);
            return redirect()->route('backend/prestasi-sekolah')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }

}