<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\QuestionType;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class QuestionTypeController extends Controller
{

    public function index(Request $request) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
        $name = !empty($request['name']) ? $request['name'] : '';
        $orderField = !empty($request['order_field']) ? $request['order_field'] : 'id';
		$orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'desc';
		$data = null;
        $questionType = QuestionType::where('name', 'like', "%${name}%")->orderBy($orderField, $orderDirection);

		if(!$limit) 
			$data = ["data" => $questionType->get()];
		else
			$data = $questionType->paginate($limit)->withQueryString();
		return response($data);
    }


    public function questionType(Request $request, $id) {
        if(!$id) 
            return response(["error" => "Not found question type ID"],400);
        $data = QuestionType::find($id);
        if($data)
            return response(["data" => $data], 200);
        else
            return response(["error" => "Not found question type ID"], 400);
     }

    public function create(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
            'description' => 'string|nullable',
        ]);

        if($validator->fails()){
            return response(["errors" =>$validator->errors()], 400);
        }

        $questionType = QuestionType::create(array_merge(
            $validator->validated(),
        ));

        return response([
            'message' => 'question type successfully created',
            'question_type' => $questionType
        ], 201);
    }

    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'string|between:2,255',
            'description' => 'string|nullable',
        ]);

        if($validator->fails()){
            return response(["errors" => $validator->errors()], 400);
        }

        $data = QuestionType::find($id);

        if(!$data) {
            return response(["errors" => "Not found question type with {$id}"], 400);
        }
     
		if(isset($params['name'])) $data->name = $params['name'];
		if(isset($params['description'])) $data->description = $params['description'];

        $data->save();
       
        return response([
            'message' => 'question type successfully edited',
            'question_type' => $data
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response(["errors" => "Not found id"], 400);
        }

        $data = QuestionType::find($id);

        if(!$data) {
            return response(["errors" => "Not found question type with {$id}"], 400);
        }

        $data->delete();

        return response([
            'message' => 'question type successfully deleted',
            'question_type' => $data
        ], 200);
    }

}