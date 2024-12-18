<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\VideoModel;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    function __construct()
    {
        $this->video_model = new VideoModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Video';
        $data['data'] = $this->video_model->list_video();
        return view('admin.video.index', $data);
    }

    function tambah_video()
    {     
        $data['title'] = 'Tambah Video';
        return view('admin.video.form_tambah', $data);
    }

    function simpan_video(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:100',
            'keterangan' => 'max:200',
            'link' => 'required|max:100'
        ],
        [
            'link.required' => 'Kolom kode video youtube harus diisi.',
            'link.max:100' => 'Kolom kode video youtube harus kurang dari atau sama dengan :value karakter.'
        ]);

        $data = [
            'judul' => $request->input('judul'),
            'keterangan' => $request->input('keterangan'),
            'link' => $request->input('link'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->video_model->simpan_video($data);
        return redirect()->route('backend/video')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_video($id)
    {   
        $cek = $this->video_model->cek_video($id);
        if($cek)
        {
            $data['title'] = 'Edit Video';
            $data['data'] = $this->video_model->get_video($id);
            return view('admin.video.form_edit', $data);
        }else
        {
            abort(404);
        }
    }  

    function update_video(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|max:100',
            'keterangan' => 'max:200',
            'link' => 'required|max:100'
        ],
        [
            'link.required' => 'Kolom kode video youtube harus diisi.',
            'link.max:100' => 'Kolom kode video youtube harus kurang dari atau sama dengan :value karakter.'
        ]);

        $data = [
            'judul' => $request->input('judul'),
            'keterangan' => $request->input('keterangan'),
            'link' => $request->input('link'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->video_model->update_video($data, $id);
        return redirect()->route('backend/video')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_video($id)
    {   
        $cek = $this->video_model->cek_video($id);
        if($cek)
        {
            $this->video_model->hapus_video($id);
            return redirect()->route('backend/video')->with(['success' => 'Data Berhasil Dihapus!']);   
        }else
        {
            abort(404);
        }
    }  

}