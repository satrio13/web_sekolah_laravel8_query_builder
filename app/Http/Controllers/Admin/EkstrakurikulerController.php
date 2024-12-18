<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\EkstrakurikulerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EkstrakurikulerController extends Controller
{
    function __construct()
    {
        $this->ekstrakurikuler_model = new EkstrakurikulerModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Ekstrakurikuler';
        $data['data'] = $this->ekstrakurikuler_model->list_ekstrakurikuler();
        return view('admin.ekstrakurikuler.index', $data);
    }

    function tambah_ekstrakurikuler()
    {     
        $data['title'] = 'Tambah Ekstrakurikuler';
        return view('admin.ekstrakurikuler.form_tambah', $data);
    }

    function simpan_ekstrakurikuler(Request $request)
    {   
        $request->validate([
            'nama_ekstrakurikuler' => 'required|max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {            
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/ekstrakurikuler'), $nama_gambar);
        }
        
        $data = [
            'nama_ekstrakurikuler' => $request->input('nama_ekstrakurikuler'),
            'gambar' => $nama_gambar,
            'keterangan' => $request->input('keterangan'),
            'slug' => Str::slug($request->input('nama_ekstrakurikuler'), '-'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->ekstrakurikuler_model->simpan_ekstrakurikuler($data);
        return redirect()->route('backend/ekstrakurikuler')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_ekstrakurikuler($id)
    {     
        $data['title'] = 'Edit Ekstrakurikuler';
        $data['data'] = $this->ekstrakurikuler_model->get_ekstrakurikuler($id);
        return view('admin.ekstrakurikuler.form_edit', $data);
    }

    function update_ekstrakurikuler(Request $request, $id)
    {   
        $request->validate([
            'nama_ekstrakurikuler' => 'required|max:100',
            'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
            
        $get = $this->ekstrakurikuler_model->cek_ekstrakurikuler($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid())
        {            
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/ekstrakurikuler'), $nama_gambar);
            if(File::exists("img/ekstrakurikuler/$get->gambar"))
            {
                File::delete("img/ekstrakurikuler/$get->gambar");
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }
        
        $data = [
            'nama_ekstrakurikuler' => $request->input('nama_ekstrakurikuler'),
            'gambar' => $nama_gambar,
            'keterangan' => $request->input('keterangan'),
            'slug' => Str::slug($request->input('nama_ekstrakurikuler'), '-'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->ekstrakurikuler_model->update_ekstrakurikuler($data, $id);
        return redirect()->route('backend/ekstrakurikuler')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_ekstrakurikuler($id)
    {
        $cek = $this->ekstrakurikuler_model->cek_ekstrakurikuler($id);
        if($cek)
        {   
            if(File::exists("img/ekstrakurikuler/$cek->gambar"))
            {
                File::delete("img/ekstrakurikuler/$cek->gambar");
            }

            $this->ekstrakurikuler_model->hapus_ekstrakurikuler($id);
            return redirect()->route('backend/ekstrakurikuler')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }  

}