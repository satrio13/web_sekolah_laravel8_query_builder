<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\TahunModel;
use Illuminate\Http\Request;

class TahunController extends Controller
{
    function __construct()
    {
        $this->tahun_model = new TahunModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Tahun Akademik';
        $data['data'] = $this->tahun_model->list_tahun();
        return view('admin.tahun.index', $data);
    }

    function tambah_tahun()
    {     
        $data['title'] = 'Tambah Tahun Akademik';
        return view('admin.tahun.form_tambah', $data);
    }

    function simpan_tahun(Request $request)
    {
        $request->validate([
            'tahun' => 'required|max:10'
        ]);

        $data = [
            'tahun' => $request->input('tahun'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->tahun_model->simpan_tahun($data);
        return redirect()->route('backend/tahun')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_tahun($id)
    {   
        $cek = $this->tahun_model->cek_tahun($id);
        if($cek)
        {
            $data['title'] = 'Edit Tahun Akademik';
            $data['data'] = $this->tahun_model->get_tahun($id);
            return view('admin.tahun.form_edit', $data);
        }else
        {
            abort(404);
        }
    }  

    function update_tahun(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|max:10'
        ]);

        $data = [
            'tahun' => $request->input('tahun'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->tahun_model->update_tahun($data, $id);
        return redirect()->route('backend/tahun')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_tahun($id)
    {
        $cek = $this->tahun_model->cek_tahun($id);
        if($cek)
        {   
            $cek_un = $this->tahun_model->cek_tahun_rekap_un($id);
            $cek_us = $this->tahun_model->cek_tahun_rekap_us($id);
            $cek_s = $this->tahun_model->cek_tahun_siswa($id);
            $cek_p_siswa = $this->tahun_model->cek_tahun_prestasi_siswa($id);
            $cek_p_guru = $this->tahun_model->cek_tahun_prestasi_guru($id);
            $cek_p_sekolah = $this->tahun_model->cek_tahun_prestasi_sekolah($id);
            $cek_a = $this->tahun_model->cek_tahun_alumni($id);
            if($cek_un OR $cek_us OR $cek_s OR $cek_p_siswa OR $cek_p_guru OR $cek_p_sekolah OR $cek_a)
            {
                return redirect()->route('backend/tahun')->with(['error' => 'Data gagal dihapus, karena sudah berelasi!']);
            }else
            {
                $this->tahun_model->hapus_tahun($id);
                return redirect()->route('backend/tahun')->with(['success' => 'Data Berhasil Dihapus!']);
            }
        }else
        {
            abort(404);
        }
    }  
    
}