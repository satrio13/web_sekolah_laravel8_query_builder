<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SiswaModel;
use App\Models\Admin\TahunModel;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    function __construct()
    {
        $this->siswa_model = new SiswaModel();
        $this->tahun_model = new TahunModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Peserta Didik';
        $data['data'] = $this->siswa_model->list_siswa();
        return view('admin.siswa.index', $data);
    }

    function tambah_siswa()
    {     
        $data['title'] = 'Tambah Peserta Didik';
        $data['tahun'] = $this->tahun_model->list_tahun();
        $data['profil'] = profil_web();
        return view('admin.siswa.form_tambah', $data);
    }

    function simpan_siswa(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jml1pa' => 'required|numeric',
            'jml1pi' => 'required|numeric',
            'jml2pa' => 'required|numeric',
            'jml2pi' => 'required|numeric',
            'jml3pa' => 'required|numeric',
            'jml3pi' => 'required|numeric'
        ]);

        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'jml1pa' => $request->input('jml1pa'),
            'jml1pi' => $request->input('jml1pi'),
            'jml2pa' => $request->input('jml2pa'),
            'jml2pi' => $request->input('jml2pi'),
            'jml3pa' => $request->input('jml3pa'),
            'jml3pi' => $request->input('jml3pi'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->siswa_model->simpan_siswa($data);
        return redirect()->route('backend/siswa')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_siswa($id)
    {   
        $cek = $this->siswa_model->cek_siswa($id);
        if($cek)
        {
            $data['title'] = 'Edit Peserta Didik';
            $data['data'] = $this->siswa_model->get_siswa($id);
            $data['tahun'] = $this->tahun_model->list_tahun();
            $data['profil'] = profil_web();
            return view('admin.siswa.form_edit', $data);
        }else
        {
            abort(404);
        }
    }  

    function update_siswa(Request $request, $id)
    {
        $request->validate([
            'id_tahun' => 'required|numeric',
            'jml1pa' => 'required|numeric',
            'jml1pi' => 'required|numeric',
            'jml2pa' => 'required|numeric',
            'jml2pi' => 'required|numeric',
            'jml3pa' => 'required|numeric',
            'jml3pi' => 'required|numeric'
        ]);

        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'jml1pa' => $request->input('jml1pa'),
            'jml1pi' => $request->input('jml1pi'),
            'jml2pa' => $request->input('jml2pa'),
            'jml2pi' => $request->input('jml2pi'),
            'jml3pa' => $request->input('jml3pa'),
            'jml3pi' => $request->input('jml3pi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->siswa_model->update_siswa($data, $id);
        return redirect()->route('backend/siswa')->with(['success' => 'Data Berhasil Diupdate!']);
    }   

    function hapus_siswa($id)
    {   
        $cek = $this->siswa_model->cek_siswa($id);
        if($cek)
        {
            $this->siswa_model->hapus_siswa($id);
            return redirect()->route('backend/siswa')->with(['success' => 'Data Berhasil Dihapus!']);   
        }else
        {
            abort(404);
        }
    }

}