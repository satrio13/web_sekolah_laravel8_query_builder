<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PengaduanModel;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    function __construct()
    {
        $this->pengaduan_model = new PengaduanModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Pengaduan';
        $data['data'] = $this->pengaduan_model->list_pengaduan();
        return view('admin.pengaduan.index', $data);
    }

    function lihat_pengaduan($id)
	{ 
        $cek = $this->pengaduan_model->cek_pengaduan($id);
        if($cek)
        {
            $data = $this->pengaduan_model->get_pengaduan($id);
            return response()->json($data);  
        }else
        {
            abort(404);
        }
    }

    function hapus_pengaduan($id)
    {
        $cek = $this->pengaduan_model->cek_pengaduan($id);
        if($cek)
        {
            $this->pengaduan_model->hapus_pengaduan($id);
            return redirect()->route('backend/pengaduan')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }  

}