<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\KaryawanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KaryawanController extends Controller
{
    function __construct()
    {
        $this->karyawan_model = new KaryawanModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Karyawan';
        $data['data'] = $this->karyawan_model->list_karyawan();
        return view('admin.karyawan.index', $data);
    }

    function tambah_karyawan()
    {     
        $data['title'] = 'Tambah Karyawan';
        return view('admin.karyawan.form_tambah', $data);
    }

    function simpan_karyawan(Request $request)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'tmp_lahir' => 'required|max:100',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'statuspeg' => 'required|max:5',
            'status' => 'required|max:10',
            'email' => 'nullable|email|max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/karyawan'), $nama_gambar);
        }
        
        $data = [
            'nama' => $request->input('nama'),
            'nip' => $request->input('nip'),
            'duk' => $request->input('duk'),
            'niplama' => $request->input('niplama'),
            'nuptk' => $request->input('nuptk'),
            'nokarpeg' => $request->input('nokarpeg'),
            'golruang' => $request->input('golruang'),
            'statuspeg' => $request->input('statuspeg'),
            'tmp_lahir' => $request->input('tmp_lahir'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'tmt_cpns' => $request->input('tmt_cpns'),
            'tmt_pns' => $request->input('tmt_pns'),
            'jk' => $request->input('jk'),
            'agama' => $request->input('agama'),
            'alamat' => $request->input('alamat'),
            'pt' => $request->input('pt'),
            'tingkat_pt' => $request->input('tingkat_pt'),
            'prodi' => $request->input('prodi'),
            'th_lulus' => $request->input('th_lulus'),
            'status' => $request->input('status'),
            'email' => $request->input('email'),
            'tugas' => $request->input('tugas'),
            'gambar' => $nama_gambar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->karyawan_model->simpan_karyawan($data);
        return redirect()->route('backend/karyawan')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_karyawan($id)
    {
        $cek = $this->karyawan_model->cek_karyawan($id);
        if($cek)
        {   
            $data['title'] = 'Edit Karyawan';
            $data['data'] = $this->karyawan_model->get_karyawan($id);
            return view('admin.karyawan.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_karyawan(Request $request, $id)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'tmp_lahir' => 'required|max:100',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'statuspeg' => 'required|max:5',
            'status' => 'required|max:10',
            'email' => 'nullable|email|max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $get = $this->karyawan_model->cek_karyawan($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/karyawan'), $nama_gambar);
            if(File::exists("img/karyawan/$get->gambar")) 
            {
                File::delete("img/karyawan/$get->gambar");
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'nama' => $request->input('nama'),
            'nip' => $request->input('nip'),
            'duk' => $request->input('duk'),
            'niplama' => $request->input('niplama'),
            'nuptk' => $request->input('nuptk'),
            'nokarpeg' => $request->input('nokarpeg'),
            'golruang' => $request->input('golruang'),
            'statuspeg' => $request->input('statuspeg'),
            'tmp_lahir' => $request->input('tmp_lahir'),
            'tgl_lahir' => $request->input('tgl_lahir'),
            'tmt_cpns' => $request->input('tmt_cpns'),
            'tmt_pns' => $request->input('tmt_pns'),
            'jk' => $request->input('jk'),
            'agama' => $request->input('agama'),
            'alamat' => $request->input('alamat'),
            'pt' => $request->input('pt'),
            'tingkat_pt' => $request->input('tingkat_pt'),
            'prodi' => $request->input('prodi'),
            'th_lulus' => $request->input('th_lulus'),
            'status' => $request->input('status'),
            'email' => $request->input('email'),
            'tugas' => $request->input('tugas'),
            'gambar' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->karyawan_model->update_karyawan($data, $id);
        return redirect()->route('backend/karyawan')->with(['success' => 'Data Berhasil Diupdate!']);
    }
    
    function hapus_karyawan($id)
    {
        $cek = $this->karyawan_model->cek_karyawan($id);
        if($cek)
        {   
            if(File::exists("img/karyawan/$cek->gambar"))
            {
                File::delete("img/karyawan/$cek->gambar");
            }

            $this->karyawan_model->hapus_karyawan($id);
            return redirect()->route('backend/karyawan')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }

    function lihat_karyawan($id)
    {
        $cek = $this->karyawan_model->cek_karyawan($id);
        if($cek)
        {   
            $data = $this->karyawan_model->get_karyawan($id);
            return response()->json($data);  
        }else
        {
            abort(404);
        }
    }

}