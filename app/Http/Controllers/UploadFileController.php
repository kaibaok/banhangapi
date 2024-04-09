<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    public function index(Request $request) {
        if ($request->hasFile('file_image')) {
            $file = $request->file('file_image')->store('images');
            return response(['data' => $file, 'result' => 'success', 'error_message' => null], 200);
        }
        return response([ 'result' => 'error', 'error_message' => 'Not found file upload'], 400);

    }
}   