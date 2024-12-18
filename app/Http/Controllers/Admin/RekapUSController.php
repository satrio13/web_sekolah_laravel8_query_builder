<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\RekapUSModel;
use App\Models\Admin\TahunModel;
use App\Models\Admin\KurikulumModel;
use Illuminate\Http\Request;

class RekapUSController extends Controller
{
    function __construct()
    {
        $this->us_model = new RekapUSModel();
        $this->tahun_model = new TahunModel();
        $this->kurikulum_model = new KurikulumModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Rekap US';
        $data['data'] = $this->us_model->list_rekap_us();
        return view('admin.rekap_us.index', $data);
    }

    function tambah_rekap_us()
    {     
        $data['title'] = 'Tambah Rekap US';
        $data['tahun'] = $this->tahun_model->list_tahun();
        $data['mapel'] = $this->kurikulum_model->list_kurikulum_order_by_mapel_asc();
        return view('admin.rekap_us.form_tambah', $data);
    }
    
    function simpan_rekap_us(Request $request)
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

        $this->us_model->simpan_rekap_us($data);
        return redirect()->route('backend/rekap-us')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_rekap_us($id)
    {
        $cek = $this->us_model->cek_rekap_us($id);
        if($cek)
        {   
            $data['title'] = 'Edit Rekap US';
            $data['data'] = $this->us_model->get_rekap_us($id);
            $data['tahun'] = $this->tahun_model->list_tahun();
            $data['mapel'] = $this->kurikulum_model->list_kurikulum_order_by_mapel_asc();
            return view('admin.rekap_us.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_rekap_us(Request $request, $id)
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

        $this->us_model->update_rekap_us($data, $id);
        return redirect()->route('backend/rekap-us')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_rekap_us($id)
    {
        $cek = $this->us_model->cek_rekap_us($id);
        if($cek)
        {   
            $this->us_model->hapus_rekap_us($id);
            return redirect()->route('backend/rekap-us')->with(['success' => 'Data Berhasil Dihapus!']);   
        }else
        {
            abort(404);
        }
    }

}