<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SarprasModel;
use Illuminate\Http\Request;

class SarprasController extends Controller
{
    function __construct()
    {
        $this->sarpras_model = new SarprasModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Sarana & Prasarana';
        $data['data'] = $this->sarpras_model->get_sarpras();
        return view('admin.sarpras.index', $data);
    }

    function edit_sarpras()
    {     
        $data['title'] = 'Edit Sarana & Prasarana';
        $data['data'] = $this->sarpras_model->get_sarpras();
        return view('admin.sarpras.form_sarpras', $data);
    }

    function update_sarpras(Request $request)
    {   
        $data = [
            'isi' => $request->input('isi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->sarpras_model->update_sarpras($data);
        return redirect()->route('backend/sarpras')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}