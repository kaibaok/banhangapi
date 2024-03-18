<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Areas;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AreasController extends Controller
{
    public function index(Request $request) {
        $params = $request->all();
        $page = !empty($params['page']) ? $params['page'] : 1;
        $limit = !empty($request['limit']) ? $request['limit'] : 0;
        $areasName = !empty($request['name']) ? $request['name']: '';
        $orderField = !empty($request['order_field']) ? $request['order_field'] : 'id';
		$orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'desc';

        $data = null;
        $areas =  Areas::where('name','like', '%'.$areasName.'%' )
            ->orWhere('full_name','like', '%'.$areasName.'%' )
            ->orderBy($orderField, $orderDirection);
            
        if(!$limit)
            $data = ["data" => $areas->get()];
        else
            $data = $areas->paginate($limit)->withQueryString();
        return response($data);
    }

    
    public function area(Request $request, $id) {
        if(!$id) 
            return response(["error" => "Not found area ID"],400);
        $data = Areas::find($id);
        if($data)
            return response(["data" => $data], 200);
        else
            return response(["error" => "Not found area ID"], 400);
     }

    public function create(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
            'full_name' => 'string',
        ]);

        if($validator->fails()){
            return response(["errors" =>$validator->errors()], 400);
        }

        $area = Areas::create(array_merge(
            $validator->validated(),
        ));

        return response([
            'message' => 'Area successfully created',
            'area' => $area
        ], 201);
    }

    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'string|between:2,255',
            'full_name' => 'string',
        ]);

        if($validator->fails()){
            return response(["errors" => $validator->errors()], 400);
        }

        $data = Areas::find($id);

        if(!$data) {
            return response(["errors" => "Not found area with {$id}"], 400);
        }
     
		if(isset($params['name'])) $data->name = $params['name'];
		if(isset($params['full_name'])) $data->full_name = $params['full_name'];

        $data->save();
       
        return response([
            'message' => 'Area successfully edited',
            'area' => $data
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response(["errors" => "Not found id"], 400);
        }

        $data = Areas::find($id);

        if(!$data) {
            return response(["errors" => "Not found area with {$id}"], 400);
        }

        $data->delete();

        return response([
            'message' => 'Area successfully deleted',
            'area' => $data
        ], 200);
    }
}