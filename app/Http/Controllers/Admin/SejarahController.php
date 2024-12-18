<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SejarahModel;
use Illuminate\Http\Request;

class SejarahController extends Controller
{
    function __construct()
    {
        $this->sejarah_model = new SejarahModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Sejarah';
        $data['data'] = $this->sejarah_model->get_sejarah();
        return view('admin.sejarah.index', $data);
    }

    function edit_sejarah()
    {     
        $data['title'] = 'Edit Sejarah';
        $data['data'] = $this->sejarah_model->get_sejarah();
        return view('admin.sejarah.form_sejarah', $data);
    }

    function update_sejarah(Request $request)
    {   
        $data = [
            'isi' => $request->input('isi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->sejarah_model->update_sejarah($data);
        return redirect()->route('backend/sejarah')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}