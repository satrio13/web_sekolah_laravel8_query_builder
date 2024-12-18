<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PrestasiSiswaModel;
use App\Models\Admin\TahunModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrestasiSiswaController extends Controller
{
    function __construct()
    {
        $this->prestasi_siswa_model = new PrestasiSiswaModel();
        $this->tahun_model = new TahunModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Prestasi Siswa';
        $data['data'] = $this->prestasi_siswa_model->list_prestasi_siswa();
        return view('admin.prestasi_siswa.index', $data);
    }

    function tambah_prestasi_siswa()
    {     
        $data['title'] = 'Tambah Prestasi Siswa';
        $data['tahun'] = $this->tahun_model->list_tahun();
        return view('admin.prestasi_siswa.form_tambah', $data);
    }

    function simpan_prestasi_siswa(Request $request)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'nama_siswa' => 'required|max:100',
            'kelas' => 'max:6',
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
            $gambar->move(public_path('img/prestasi_siswa'), $nama_gambar);
        }
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'nama' => $request->input('nama'),
            'prestasi' => $request->input('prestasi'),
            'nama_siswa' => $request->input('nama_siswa'),
            'kelas' => $request->input('kelas'),
            'tingkat' => $request->input('tingkat'),
            'jenis' => $request->input('jenis'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $nama_gambar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->prestasi_siswa_model->simpan_prestasi_siswa($data);
        return redirect()->route('backend/prestasi-siswa')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_prestasi_siswa($id)
    {   
        $cek = $this->prestasi_siswa_model->cek_prestasi_siswa($id);
        if($cek)
        {
            $data['title'] = 'Edit Prestasi Siswa';
            $data['data'] = $this->prestasi_siswa_model->get_prestasi_siswa($id);
            $data['tahun'] = $this->tahun_model->list_tahun();
            return view('admin.prestasi_siswa.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_prestasi_siswa(Request $request, $id)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jenis' => 'required|numeric',
            'nama' => 'required|max:100',
            'prestasi' => 'required|max:100',
            'nama_siswa' => 'required|max:100',
            'kelas' => 'max:6',
            'tingkat' => 'required|numeric',
            'keterangan' => 'max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ],
        [
            'nama.required' => 'Kolom nama lomba harus diisi.',
            'nama.max:100' => 'Kolom nama lomba harus kurang dari atau sama dengan :value karakter.'
        ]);
            
        $get = $this->prestasi_siswa_model->cek_prestasi_siswa($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/prestasi_siswa'), $nama_gambar);
            if(File::exists("img/prestasi_siswa/$get->gambar"))
            {
                File::delete("img/prestasi_siswa/$get->gambar");
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'nama' => $request->input('nama'),
            'prestasi' => $request->input('prestasi'),
            'nama_siswa' => $request->input('nama_siswa'),
            'kelas' => $request->input('kelas'),
            'tingkat' => $request->input('tingkat'),
            'jenis' => $request->input('jenis'),
            'keterangan' => $request->input('keterangan'),
            'gambar' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->prestasi_siswa_model->update_prestasi_siswa($data, $id);
        return redirect()->route('backend/prestasi-siswa')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_prestasi_siswa($id)
    {   
        $cek = $this->prestasi_siswa_model->cek_prestasi_siswa($id);
        if($cek)
        {
            if(File::exists("img/prestasi_siswa/$cek->gambar"))
            {
                File::delete("img/prestasi_siswa/$cek->gambar");
            }

            $this->prestasi_siswa_model->hapus_prestasi_siswa($id);
            return redirect()->route('backend/prestasi-siswa')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }
   
}