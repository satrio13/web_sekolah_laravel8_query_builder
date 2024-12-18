<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AlbumModel;
use App\Models\VideoModel;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    function __construct()
    {
        $this->album_model = new AlbumModel();
        $this->video_model = new VideoModel();
    }

    function foto()
    {     
        $data['titleweb'] = 'Galeri Foto - '.title();
		$data['title'] = 'Foto';
        $data['data'] = $this->album_model->list_album(8);
        return view('galeri/foto', $data);
    }

    function album($slug)
    {
        $cek = $this->album_model->cek_album($slug);
        if($cek)
        {
            $get = $this->album_model->get_album($slug);
            $data['titleweb'] = $get->album.' - '.title();
            $data['title'] = $get->album;
            $data['data'] = $this->album_model->list_foto($slug);
            return view('galeri/album', $data);
        }else
        {
            abort(404);
        }   
    }

    function video()
    {
        $data['titleweb'] = 'Galeri Video - '.title();
		$data['title'] = 'Video';
        $data['data'] = $this->video_model->list_video(8);
        return view('galeri/video', $data);
    }

}