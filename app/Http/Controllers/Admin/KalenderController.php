<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\KalenderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KalenderController extends Controller
{
    function __construct()
    {
        $this->kalender_model = new KalenderModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Kalender';
        $data['data'] = $this->kalender_model->get_kalender();
        return view('admin.kalender.index', $data);
    }

    function update_kalender(Request $request)
    {   
        $request->validate([
            'file' => 'max:5120'
        ]);
            
        $get = $this->kalender_model->get_kalender();
        if($request->hasFile('file') AND $request->file('file')->isValid())
        {
            $gambar = $request->file('file');
            $nama_gambar = time().'_'.$gambar->getClientOriginalName();
            $gambar->move(public_path('img/kalender'), $nama_gambar);
            if(File::exists("img/kalender/$get->kalender"))
            {
                File::delete("img/kalender/$get->kalender");
            }
        }else
        {
            $nama_gambar = '';
        }
        
        $data = [
            'kalender' => $nama_gambar,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->kalender_model->update_kalender($data);
        return redirect()->route('backend/kalender')->with(['success' => 'Data Berhasil Diupdate!']);
    }
    
}