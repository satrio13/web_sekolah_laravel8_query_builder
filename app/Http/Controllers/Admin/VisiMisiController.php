<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\VisiMisiModel;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    function __construct()
    {
        $this->visi_misi_model = new VisiMisiModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Visi & Misi';
        $data['data'] = $this->visi_misi_model->get_visi_misi();
        return view('admin.visi_misi.index', $data);
    }

    function edit_visi_misi()
    {     
        $data['title'] = 'Edit Visi & Misi';
        $data['data'] = $this->visi_misi_model->get_visi_misi();
        return view('admin.visi_misi.form_visi_misi', $data);
    }

    function update_visi_misi(Request $request)
    {   
        $data = [
            'isi' => $request->input('isi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->visi_misi_model->update_visi_misi($data);
        return redirect()->route('backend/visi-misi')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}