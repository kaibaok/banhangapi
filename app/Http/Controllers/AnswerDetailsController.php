<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\AnswerDetails;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class AnswerDetailsController extends Controller
{

    public function index(Request $request) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
        $questionID = isset($request['question_id']) ? $request['question_id'] : '';
		$orderField = !empty($request['order_field']) ? $request['order_field'] : 'order_number';
		$orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'asc';

        $data = null;
        
        $answerDetails = AnswerDetails::orderBy($orderField,$orderDirection);
                
        if($questionID) 
           $answerDetails = $answerDetails->where('question_id', $questionID);
           
        if(!$limit)
            $data = ["data" =>  $answerDetails->get() ];
        else
            $data = $answerDetails->paginate($limit)->withQueryString();
            
        if(!is_array($data)) {
            $data = $data->toArray();
        }     

        if(!empty($data['data'])) {
            foreach ($data['data'] as &$item) {
                $answers_arr =  explode("\n",$item['answers']);
                $questions_arr = explode("\n",$item['questions']);
                $item['answers_arr'] = array_filter($answers_arr);
                $item['questions_arr'] = array_filter($questions_arr);
            }
        }
        return response($data);
    }
    
    public function createList(Request $request,  $id) {
        $params = $request->all();
        
        if(!$id) {
            return response(["error" => "Not found question ID"],400);
        }
    
        $validator = Validator::make($request->json()->all(), [
            'answers' => 'array|nullable',
        ]);

        if($validator->fails()){
            return response(["errors" =>$validator->errors()], 400);
        }
        
     	$answers = $params['answers'];
        
        AnswerDetails::where('question_id', $id)->delete();

        if(!empty($answers) && count($answers) > 0) {
            foreach($answers as $key => &$answer) {
                $answer['question_id'] = $id;
                $answer['order_number'] = $key;
            }

            if(!AnswerDetails::insert($answers)) {
                return response(["error" => "Answers create failed"], 400);
            }
        }

        return response([
            'message' => 'Answers successfully created',
            "answers" => $answers
        ], 201);
    }
}