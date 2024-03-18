<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Question;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class QuestionController extends Controller
{

    public function index(Request $request) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
		$questionName = !empty($request['name']) ? $request['name'] : '';
        $question_type_id = isset($request['question_type_id']) ? $request['question_type_id'] : '';
        $orderField = !empty($request['order_field']) ? $request['order_field'] : 'id';
        $orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'desc';
		$data = null;
        $questions = Question::orderBy($orderField, $orderDirection)->with('question_type');

        if($question_type_id) 
          $questions = $questions->where('question_type_id', $question_type_id);
        
        if($questionName) 
            $questions = $questions->where('name','like', "%{$questionName}%");
  
        if(!$limit) 
          $data = ["data" => $questions->get()];
        else
          $data = $questions->paginate($limit)->withQueryString();

        return response($data);
    }


    public function question(Request $request, $id) {
        if(!$id) 
            return response(["error" => "Not found question ID"],400);
        $data = Question::find($id);
        if($data)
            return response(["data" => $data], 200);
        else
            return response(["error" => "Not found question ID"], 400);
     }

    public function create(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
            'description' => 'string|nullable',
            'question_type_id' => 'int|min:0',
            'order_number' => 'int|min:0',
        ]);

        if($validator->fails()){
            return response(["errors" =>$validator->errors()], 400);
        }

        $question = Question::create(array_merge(
            $validator->validated(),
        ));

        return response([
            'message' => 'Question successfully created',
            'question' => $question
        ], 201);
    }

    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'string|between:2,255',
            'description' => 'string|nullable',
            'order_number' => 'int|min:0',
        ]);

        if($validator->fails()){
            return response(["errors" => $validator->errors()], 400);
        }

        $data = Question::find($id);

        if(!$data) {
            return response(["errors" => "Not found question with {$id}"], 400);
        }
     
		if(isset($params['name'])) $data->name = $params['name'];
		if(isset($params['description'])) $data->description = $params['description'];
		if(isset($params['question_type_id'])) $data->question_type_id = (int) $params['question_type_id'];
		if(isset($params['order_number'])) $data->order_number = (int) $params['order_number'];
      
        $data->save();
       
        return response([
            'message' => 'Question successfully edited',
            'question' => $data
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response(["errors" => "Not found id"], 400);
        }

        $data = Question::find($id);

        if(!$data) {
            return response(["errors" => "Not found question with {$id}"], 400);
        }

        $data->delete();

        return response([
            'message' => 'Question successfully deleted',
            'question_type' => $data
        ], 200);
    }

}