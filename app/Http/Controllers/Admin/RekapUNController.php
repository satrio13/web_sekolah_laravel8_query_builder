<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\RekapUNModel;
use App\Models\Admin\TahunModel;
use App\Models\Admin\KurikulumModel;
use Illuminate\Http\Request;

class RekapUNController extends Controller
{
    function __construct()
    {
        $this->un_model = new RekapUNModel();
        $this->tahun_model = new TahunModel();
        $this->kurikulum_model = new KurikulumModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Rekap UN';
        $data['data'] = $this->un_model->list_rekap_un();
        return view('admin.rekap_un.index', $data);
    }

    function tambah_rekap_un()
    {     
        $data['title'] = 'Tambah Rekap UN';
        $data['tahun'] = $this->tahun_model->list_tahun();
        $data['mapel'] = $this->kurikulum_model->list_kurikulum_order_by_mapel_asc();
        return view('admin.rekap_un.form_tambah', $data);
    }
    
    function simpan_rekap_un(Request $request)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'id_kurikulum' => 'required|numeric',
            'tertinggi' => 'required|numeric',
            'terendah' => 'required|numeric',
            'rata' => 'required|numeric'
        ]);
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'id_kurikulum' => $request->input('id_kurikulum'),
            'tertinggi' => $request->input('tertinggi'),
            'terendah' => $request->input('terendah'),
            'rata' => $request->input('rata'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->un_model->simpan_rekap_un($data);
        return redirect()->route('backend/rekap-un')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_rekap_un($id)
    {
        $cek = $this->un_model->cek_rekap_un($id);
        if($cek)
        {   
            $data['title'] = 'Edit Rekap UN';
            $data['data'] = $this->un_model->get_rekap_un($id);
            $data['tahun'] = $this->tahun_model->list_tahun();
            $data['mapel'] = $this->kurikulum_model->list_kurikulum_order_by_mapel_asc();
            return view('admin.rekap_un.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_rekap_un(Request $request, $id)
    {   
        $request->validate([
            'id_tahun' => 'required|numeric',
            'id_kurikulum' => 'required|numeric',
            'tertinggi' => 'required|numeric',
            'terendah' => 'required|numeric',
            'rata' => 'required|numeric'
        ]);
        
        $data = [
            'id_tahun' => $request->input('id_tahun'),
            'id_kurikulum' => $request->input('id_kurikulum'),
            'tertinggi' => $request->input('tertinggi'),
            'terendah' => $request->input('terendah'),
            'rata' => $request->input('rata'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->un_model->update_rekap_un($data, $id);
        return redirect()->route('backend/rekap-un')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_rekap_un($id)
    {
        $cek = $this->un_model->cek_rekap_un($id);
        if($cek)
        {   
            $this->un_model->hapus_rekap_un($id);
            return redirect()->route('backend/rekap-un')->with(['success' => 'Data Berhasil Dihapus!']);   
        }else
        {
            abort(404);
        }
    }

}