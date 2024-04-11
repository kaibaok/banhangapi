<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\DB;
use Validator;

class FoodController extends Controller
{
    public function getPage(Request $request) {
		$limit = !empty($request['limit']) ? $request['limit'] : 30;
        $category_id = isset($request['category_id']) ? $request['category_id'] : 0;
        $status = isset($request['status']) ? $request['status'] : 0;
        $name = isset($request['name']) ? $request['name'] : '';
        $description = isset($request['description']) ? $request['description'] : '';
        
        $results = DB::table('food')
        ->selectRaw("food.*, category_food.name as category_name")
        ->leftJoin('category_food', 'food.category_id', '=', 'category_food.id')
        ->where('food.name' ,'like', "%{$name}%")
        ->where('food.description' ,'like', "%{$description}%");

        if($category_id) {
            $results = $results->where('food.category_id','=', $category_id);    
        }
        if($status) {
            $results = $results->where('food.status','=', $status);    
        }
        
        $data = $results->paginate($limit)->withQueryString()->toArray();

        return response(['foods' => $data, 'result' => 'Success', 'error_message' => null]);
    }

    public function getID(Request $request, $id) {
        if(!$id) 
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$id}" ],400);
        $data = Food::find($id);
        if($data)
            return response(['food' => $data, 'result' => 'Success', 'error_message' => null]);
        else
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$id}"], 400);
     }

    public function create(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
            'category_id' => 'required|int',
            'code' => 'required|string',
            'price' => 'required|int',
            'image_url' => 'string',
            'description' => 'string',
            'status' => 'int',
        ]);

        if($validator->fails()){
            return response([
                'result' => 'error',
                "error_message" =>$validator->errors()
            ], 400);
        }

        $result = Food::create(array_merge(
            $validator->validated(),
        ));

        return response([
            'result' => 'Success',
            'error_message' => null,
            'food' => $result
        ], 201);
    }

    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'required|string|between:2,255',
            'category_id' => 'required|int',
            'code' => 'required|string',
            'price' => 'required|int',
            'image_url' => 'string',
            'description' => 'string',
            'status' => 'int',
        ]);

        if($validator->fails()){
            return response([
                'result' => 'error',
                "error_message" => $validator->errors()
            ], 400);
        }

        $result = Food::find($id);

        if(!$result) {
            return response(['result' => 'error', "error_message"  => "Not found ID {$id}"], 400); }
     
		if(isset($params['name'])) $result->name = $params['name'];
		if(isset($params['category_id'])) $result->category_id = $params['category_id'];
		if(isset($params['code'])) $result->code = $params['code'];
		if(isset($params['price'])) $result->price = $params['price'];
		if(isset($params['image_url'])) $result->image_url = $params['image_url'];
		if(isset($params['description'])) $result->description = $params['description'];
		if(isset($params['status'])) $result->status = $params['status'];
        if(isset($params['create_at'])) $result->create_at = $params['create_at'];
        if(isset($params['update_at'])) $result->update_at = $params['update_at'];

        $result->save();
       
        return response([
            'result' => 'Success',
            'error_message' => null,
            'food' => $result
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response([ 'result' => 'error', "error_message"  => "Not found ID {$id}"], 400); }

        $data = Food::find($id);

        if(!$data) {
            return response([ 'result' => 'error', "error_message" => "Not found ID {$id}"], 400); }

        $data->delete();

        return response([
            'result' => 'Success',
            'error_message' => null,
            'data' => $data
        ], 200);
    }
}