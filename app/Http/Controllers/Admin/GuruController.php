<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\GuruModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GuruController extends Controller
{
    function __construct()
    {
        $this->guru_model = new GuruModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Guru';
        $data['data'] = $this->guru_model->list_guru();
        return view('admin.guru.index', $data);
    }

    function tambah_guru()
    {     
        $data['title'] = 'Tambah Guru';
        return view('admin.guru.form_tambah', $data);
    }

    function simpan_guru(Request $request)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'tmp_lahir' => 'required|max:100',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'statuspeg' => 'required|max:5',
            'status' => 'required|max:10',
            'statusguru' => 'required|max:12',
            'email' => 'nullable|email|max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {            
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/guru'), $nama_gambar);
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
            'statusguru' => $request->input('statusguru'),
            'gambar' => $nama_gambar,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->guru_model->simpan_guru($data);
        return redirect()->route('backend/guru')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_guru($id)
    {
        $cek = $this->guru_model->cek_guru($id);
        if($cek)
        {   
            $data['title'] = 'Edit Guru';
            $data['data'] = $this->guru_model->get_guru($id);
            return view('admin.guru.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_guru(Request $request, $id)
    {   
        $request->validate([
            'nama' => 'required|max:100',
            'tmp_lahir' => 'required|max:100',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'statuspeg' => 'required|max:5',
            'status' => 'required|max:10',
            'statusguru' => 'required|max:12',
            'email' => 'nullable|email|max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $get = $this->guru_model->cek_guru($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/guru'), $nama_gambar);
            if(File::exists("img/guru/$get->gambar"))
            {
                File::delete("img/guru/$get->gambar");
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
            'statusguru' => $request->input('statusguru'),
            'gambar' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->guru_model->update_guru($data, $id);
        return redirect()->route('backend/guru')->with(['success' => 'Data Berhasil Diupdate!']);
    }
    
    function hapus_guru($id)
    {
        $cek = $this->guru_model->cek_guru($id);
        if($cek)
        {   
            if(File::exists("img/guru/$cek->gambar"))
            {
                File::delete("img/guru/$cek->gambar");
            }

            $this->guru_model->hapus_guru($id);
            return redirect()->route('backend/guru')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }

    function lihat_guru($id)
    {
        $cek = $this->guru_model->cek_guru($id);
        if($cek)
        {   
            $data = $this->guru_model->get_guru($id);
            return response()->json($data);  
        }else
        {
            abort(404);
        }
    }

}