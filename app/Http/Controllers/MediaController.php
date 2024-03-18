<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function uploadFile(Request $request) {
        if(!empty($_FILES)) {
            foreach ($_FILES as $file) {
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = uniqid().strtotime("now").".{$ext}";
                $folderName = storage_path('app/public');
                $folderName .= ($ext == "mp4") ? "\/videos/" : "\/images/";
                move_uploaded_file($file['tmp_name'] , $folderName.$fileName);
            }
        } else {
            return response(["error" => "Empty files"], 400);
        }
        return response(["message" => "Files Uploaded"], 200);
    }

    public function listImages() {
        $files =  Storage::disk('public')->allFiles('images');
        rsort($files);
        return response([
            "images" => $files,
        ]);
    }

    public function listVideos() {
        $files =  Storage::disk('public')->allFiles('videos');
        rsort($files);
        return response([
            "videos" => $files,
        ]);
    }

    public function deleteItems (Request $request) {
        $params = $request->all();
        if(empty($params) || empty($params['files'])) {
            return response(["error" => "No files chosen or not found folder"], 400);
        } 
        $files = $params['files'];
        foreach($files as $file) {
            if(Storage::disk('public')->exists($file)){
                Storage::disk('public')->delete($file);
            }
        }
        return response(["message" => "Files deleted"], 200);

    }

}