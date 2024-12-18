<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AlbumModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    function __construct()
    {
        $this->album_model = new AlbumModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Album';
        $data['data'] = $this->album_model->list_album();
        return view('admin.album.index', $data);
    }

    function tambah_album()
    {     
        $data['title'] = 'Tambah Album';
        return view('admin.album.form_tambah', $data);
    }

    function simpan_album(Request $request)
    {
        $request->validate([
            'album' => 'required|max:50',
            'is_active' => 'required'
        ]);

        $data = [
            'album' => $request->input('album'),
            'is_active' => $request->input('is_active'),
            'slug' => Str::slug($request->input('album'), '-'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->album_model->simpan_album($data);
        return redirect()->route('backend/album')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_album($id)
    {   
        $cek = $this->album_model->cek_album($id);
        if($cek)
        {
            $data['title'] = 'Edit Album';
            $data['data'] = $this->album_model->get_album($id);
            return view('admin.album.form_edit', $data);
        }else
        {
            abort(404);
        }
    }  

    function update_album(Request $request, $id)
    {
        $request->validate([
            'album' => 'required|max:50',
            'is_active' => 'required'
        ]);

        $data = [
            'album' => $request->input('album'),
            'is_active' => $request->input('is_active'),
            'slug' => Str::slug($request->input('album'), '-'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->album_model->update_album($data, $id);
        return redirect()->route('backend/album')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_album($id)
    {
        $cek_foto = $this->album_model->cek_album_foto($id);
        if($cek_foto)
        {
            return redirect()->route('backend/album')->with(['error' => 'Data gagal dihapus, karena sudah berelasi!']);
        }else
        {
            $this->album_model->hapus_album($id);
            return redirect()->route('backend/album')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }

}