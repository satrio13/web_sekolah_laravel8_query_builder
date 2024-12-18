<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AgendaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AgendaController extends Controller
{
    function __construct()
    {
        $this->agenda_model = new AgendaModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Agenda';
        $data['data'] = $this->agenda_model->list_agenda();
        return view('admin.agenda.index', $data);
    }

    function tambah_agenda()
    {     
        $data['title'] = 'Tambah Agenda';
        return view('admin.agenda.form_tambah', $data);
    }

    function simpan_agenda(Request $request)
    {   
        if($request->input('berapa_hari') == '1')
        {
            $request->validate([
                'nama_agenda' => 'required|max:100',
                'berapa_hari' => 'required|numeric',
                'tgl' => 'required|date',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'tempat' => 'required|max:100',
                'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
            ]);
        }else
        {
            $request->validate([
                'nama_agenda' => 'required|max:100',
                'berapa_hari' => 'required|numeric',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'tempat' => 'required|max:100',
                'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
            ]);
        }
            
        $nama_gambar = '';
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/agenda'), $nama_gambar);
        }
        
        $data = [
            'nama_agenda' => $request->input('nama_agenda'),
            'berapa_hari' => $request->input('berapa_hari'),
            'tgl' => $request->input('tgl'),
            'tgl_mulai' => $request->input('tgl_mulai'),
            'tgl_selesai' => $request->input('tgl_selesai'),
            'jam_mulai' => $request->input('jam_mulai'),
            'jam_selesai' => $request->input('jam_selesai'),
            'keterangan' => $request->input('keterangan'),
            'tempat' => $request->input('tempat'),
            'gambar' => $nama_gambar,
            'slug' => Str::slug($request->input('nama_agenda'), '-'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->agenda_model->simpan_agenda($data);
        return redirect()->route('backend/agenda')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    function edit_agenda($id)
    {   
        $cek = $this->agenda_model->cek_agenda($id);
        if($cek)
        {
            $data['title'] = 'Edit Agenda';
            $data['data'] = $this->agenda_model->get_agenda($id);
            return view('admin.agenda.form_edit', $data);
        }else
        {
            abort(404);
        }
    }  

    function update_agenda(Request $request, $id)
    {
        if($request->input('berapa_hari') == '1')
        {
            $request->validate([
                'nama_agenda' => 'required|max:100',
                'berapa_hari' => 'required|numeric',
                'tgl' => 'required|date',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'tempat' => 'required|max:100',
                'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
            ]);
        }else
        {
            $request->validate([
                'nama_agenda' => 'required|max:100',
                'berapa_hari' => 'required|numeric',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'required|date',
                'jam_mulai' => 'required',
                'jam_selesai' => 'required',
                'tempat' => 'required|max:100',
                'gambar' => 'image|mimes:jpeg,jpg,png|max:1024'
            ]);
        }

        $get = $this->agenda_model->cek_agenda($id);
        if($request->hasFile('gambar') AND $request->file('gambar')->isValid()) 
        {
            $gambar = $request->file('gambar');
            $nama_gambar = time().'_'.$gambar->hashName();
            $gambar->move(public_path('img/agenda'), $nama_gambar);
            if(File::exists("img/agenda/$get->gambar"))
            {
                File::delete("img/agenda/$get->gambar");
            }
        }else
        {
            $nama_gambar = $get->gambar;
        }

        $data = [
            'nama_agenda' => $request->input('nama_agenda'),
            'berapa_hari' => $request->input('berapa_hari'),
            'tgl' => $request->input('tgl'),
            'tgl_mulai' => $request->input('tgl_mulai'),
            'tgl_selesai' => $request->input('tgl_selesai'),
            'jam_mulai' => $request->input('jam_mulai'),
            'jam_selesai' => $request->input('jam_selesai'),
            'keterangan' => $request->input('keterangan'),
            'tempat' => $request->input('tempat'),
            'gambar' => $nama_gambar,
            'slug' => Str::slug($request->input('nama_agenda'), '-'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->agenda_model->update_agenda($data, $id);
        return redirect()->route('backend/agenda')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    function hapus_agenda($id)
    {
        $cek = $this->agenda_model->cek_agenda($id);
        if($cek)
        {   
            if(File::exists("img/agenda/$cek->gambar"))
            {
                File::delete("img/agenda/$cek->gambar");
            }

            $this->agenda_model->hapus_agenda($id);
            return redirect()->route('backend/agenda')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }  

}