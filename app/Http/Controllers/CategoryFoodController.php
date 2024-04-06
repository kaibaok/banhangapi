<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\CategoryFood;
use Validator;

class CategoryFoodController extends Controller
{
    public function index(Request $request) {
		$limit = !empty($request['limit']) ? $request['limit'] : 30;
        $status = isset($request['status']) ? $request['status'] : 0;
        $name = isset($request['name']) ? $request['name'] : '';
        
        $results = CategoryFood::where('name', 'like', "%{$name}%");
        if($status) {
            $results = $results->where('status','=', $status);    
        }
        $data = $results->paginate($limit)->withQueryString()->toArray();

        return response(['data' => $data, 'result' => 'success', 'error_message' => null]);
    }

    public function getID(Request $request, $id) {
        if(!$id) 
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$id}" ],400);
        $data = CategoryFood::find($id);
        if($data)
            return response(['data' => $data, 'result' => 'success', 'error_message' => null]);
        else
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$id}"], 400);
     }

    public function create(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
            'status' => 'int',
        ]);

        if($validator->fails()){
            return response([
                'result' => 'error',
                "error_message" =>$validator->errors()
            ], 400);
        }

        $result = CategoryFood::create(array_merge(
            $validator->validated(),
        ));

        return response([
            'result' => 'success',
            'error_message' => null,
            'data' => $result
        ], 201);
    }

    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'required|string|between:2,255',
            'status' => 'int',
        ]);

        if($validator->fails()){
            return response([
                'result' => 'error',
                "error_message" => $validator->errors()
            ], 400);
        }

        $result = CategoryFood::find($id);

        if(!$result) {
            return response(['result' => 'error', "error_message"  => "Not found ID {$id}"], 400); }
     
		if(isset($params['name'])) $result->name = $params['name'];
		if(isset($params['category_id'])) $result->category_id = $params['category_id'];
		if(isset($params['code'])) $result->code = $params['code'];
		if(isset($params['price'])) $result->price = $params['price'];
		if(isset($params['image_url'])) $result->image_url = $params['image_url'];
		if(isset($params['description'])) $result->description = $params['description'];
		if(isset($params['status'])) $result->status = $params['status'];

        $result->save();
       
        return response([
            'result' => 'success',
            'error_message' => null,
            'data' => $result
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response([ 'result' => 'error', "error_message"  => "Not found ID {$id}"], 400); }

        $data = CategoryFood::find($id);

        if(!$data) {
            return response([ 'result' => 'error', "error_message" => "Not found ID {$id}"], 400); }

        $data->delete();

        return response([
            'result' => 'success',
            'error_message' => null,
            'data' => $data
        ], 200);
    }
}