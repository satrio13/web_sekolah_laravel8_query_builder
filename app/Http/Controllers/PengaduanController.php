<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PengaduanModel;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    function __construct()
    {
        $this->pengaduan_model = new PengaduanModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['titleweb'] = 'Layanan Pengaduan - '.title();
        $data['title'] = 'Layanan Pengaduan';
        return view('pengaduan.index', $data);
    }

    function simpan_pengaduan(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'status' => 'required',
            'isi' => 'required'
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'status' => $request->input('status'),
            'isi' => $request->input('isi'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->pengaduan_model->simpan_pengaduan($data);
        return redirect()->route('pengaduan')->with(['success' => 'TERIMAKASIH, DATA BERHASIL DIKIRIM']);
    }

}