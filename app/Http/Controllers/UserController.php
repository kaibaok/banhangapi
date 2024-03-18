<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Validator;

class UserController extends Controller
{
    public function index(Request $request) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
        $name = isset($request['name']) ? $request['name'] : 'None';

        $data = null;
        
        $user = User::where('name', 'like', "%{$name}%");
           
        if(!$limit)
            $data = ["data" =>  $user->get() ];
        else
            $data = $user->paginate($limit)->withQueryString();
            
        if(!is_array($data)) {
            $data = $data->toArray();
        }     

        return response($data);
    }
}