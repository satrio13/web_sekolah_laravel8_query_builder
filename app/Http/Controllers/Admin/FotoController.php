<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\FotoModel;
use App\Models\Admin\AlbumModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FotoController extends Controller
{
    function __construct()
    {
        $this->foto_model = new FotoModel();
        $this->album_model = new AlbumModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    function index()
    {     
        $data['title'] = 'Foto';
        $data['album'] = $this->album_model->list_album_order_by_name_asc();
        $data['data'] = $this->foto_model->list_foto();
        return view('admin.foto.index', $data);
    }

    function simpan_foto(Request $request)
    {   
        $request->validate([
            'id_album' => 'required',
            'files.*' => 'image|mimes:jpeg,jpg,png|max:7168'
        ]);

        $files = $request->file('files');
        if(!empty($files))
        {
            foreach($files as $file)
            {
                $nama_file = time().'_'.$file->hashName();
                $file->move(public_path('img/foto'), $nama_file);

                $data = [
                    'id_album' => $request->input('id_album'),
                    'foto' => $nama_file,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $this->foto_model->simpan_foto($data);
            }
            
            return redirect()->route('backend/foto')->with(['success' => 'File Berhasil Diupload!']);
        }else
        {
            return redirect()->back()->withInput()->with(['error' => 'File gagal diupload! periksa kembali format dan ukuran file anda..']);
        }
    }

    function hapus_foto($id)
    {
        $cek = $this->foto_model->get_foto($id);
        if($cek)
        {   
            if(File::exists("img/foto/$cek->foto"))
            {
                File::delete("img/foto/$cek->foto");
            }

            $this->foto_model->hapus_foto($id);
            return redirect()->route('backend/foto')->with(['success' => 'Data Berhasil Dihapus!']);
        }else
        {
            abort(404);
        }
    }  

}