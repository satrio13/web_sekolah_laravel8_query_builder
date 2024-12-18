<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\LinkModel;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    function __construct()
    {
        $this->link_model = new LinkModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Link Terkait';
        $data['data'] = $this->link_model->list_link();
        return view('admin.link.index', $data);
    }

    function tambah_link()
    {     
        $data['title'] = 'Tambah Link Terkait';
        return view('admin.link.form_tambah', $data);
    }

    function simpan_link(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'link' => 'required|url',
            'is_active' => 'required'
        ],
        [
            'nama.required' => 'Kolom nama halaman harus diisi.',
            'nama.max:100' => 'Kolom nama halaman harus kurang dari atau sama dengan :value karakter.'
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'link' => $request->input('link'),
            'is_active' => $request->input('is_active'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->link_model->simpan_link($data);
        return redirect()->route('backend/link')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_link($id)
    {   
        $cek = $this->link_model->cek_link($id);
        if($cek)
        {
            $data['title'] = 'Edit Link Terkait';
            $data['data'] = $this->link_model->get_link($id);
            return view('admin.link.form_edit', $data);
        }else
        {
            abort(404);
        }
    }  

    function update_link(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'link' => 'required|url',
            'is_active' => 'required'
        ],
        [
            'nama.required' => 'Kolom nama halaman harus diisi.',
            'nama.max:100' => 'Kolom nama halaman harus kurang dari atau sama dengan :value karakter.'
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'link' => $request->input('link'),
            'is_active' => $request->input('is_active'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->link_model->update_link($data, $id);
        return redirect()->route('backend/link')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_link($id)
    {
        $cek = $this->link_model->cek_link($id);
        if($cek)
        {
            $this->link_model->hapus_link($id);
            return redirect()->route('backend/link')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }  
    
}