<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\DownloadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DownloadController extends Controller
{
    function __construct()
    {
        $this->download_model = new DownloadModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Download';
        $data['data'] = $this->download_model->list_download();
        return view('admin.download.index', $data);
    }

    function tambah_download()
    {     
        $data['title'] = 'Tambah Download';
        return view('admin.download.form_tambah', $data);
    }

    function simpan_download(Request $request)
    {   
        $request->validate([
            'nama_file' => 'required|max:100',
            'is_active' => 'required',
            'file' => 'required|max:7168'
        ]);
            
        $nama_file = '';
        if($request->hasFile('file') AND $request->file('file')->isValid())
        {
            $file = $request->file('file');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('file'), $nama_file);
        }
        
        $data = [
            'nama_file' => $request->input('nama_file'),
            'file' => $nama_file,
            'hits' => 0,
            'id_user' => session('id_user'),
            'is_active' => $request->input('is_active'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->download_model->simpan_download($data);
        return redirect()->route('backend/download')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_download($id)
    {     
        $cek = $this->download_model->cek_download($id);
        if($cek)
        {
            $data['title'] = 'Edit Download';
            $data['data'] = $this->download_model->get_download($id);
            return view('admin.download.form_edit', $data);
        }else
        {
            abort(404);
        }
    }

    function update_download(Request $request, $id)
    {   
        $request->validate([
            'nama_file' => 'required|max:100',
            'is_active' => 'required',
            'file' => 'max:7168'
        ]);
            
        $get = $this->download_model->cek_download($id);
        if($request->hasFile('file') AND $request->file('file')->isValid())
        {   
            $file = $request->file('file');
            $nama_file = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('file'), $nama_file);
            if(File::exists("file/$get->file"))
            {
                File::delete("file/$get->file");
            }
        }else
        {
            $nama_file = $get->file;
        }
        
        $data = [
            'nama_file' => $request->input('nama_file'),
            'file' => $nama_file,
            'id_user' => session('id_user'),
            'is_active' => $request->input('is_active'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->download_model->update_download($data, $id);
        return redirect()->route('backend/download')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_download($id)
    {
        $cek = $this->download_model->cek_download($id);
        if($cek)
        {   
            if(File::exists("file/$cek->file"))
            {
                File::delete("file/$cek->file");
            }

            $this->download_model->hapus_download($id);
            return redirect()->route('backend/download')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }  

}