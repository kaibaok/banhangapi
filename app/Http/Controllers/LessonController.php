<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Lesson;
use App\Models\LessonDetails;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class LessonController extends Controller
{
    public function index(Request $request) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
		$lessonName = !empty($request['name']) ? $request['name'] : '';
        $orderField = !empty($request['order_field']) ? $request['order_field'] : 'id';
		$orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'desc';
		$data = null;
        $lesson = Lesson::where('name','like', "%{$lessonName}%")
            ->orderBy($orderField, $orderDirection);

		if(!$limit) 
			$data = ["data" => $lesson->get()];
		else
			$data = $lesson->paginate($limit)->withQueryString();
            
		return response($data);
    }


    public function Lesson(Request $request, $id) {
        if(!$id) 
            return response(["error" => "Not found lesson ID"], 400);
        $data = Lesson::find($id);
        if($data)
            return response(["data" => $data], 200);
        else
            return response(["error" => "Not found lesson ID"], 400);
     }

    public function create(Request $request) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'required|string|between:2,255',
            'description' => 'string|nullable',
            'image' => 'string|nullable',
            'order_number' => 'int|min:0',
        ]);

        if($validator->fails()){
            return response(["errors" =>$validator->errors()], 400);
        }

        $lesson = Lesson::create(array_merge(
            $validator->validated(),
        ));
        
        LessonDetails::where('lesson_id', $lesson->id)->delete();

        if(!empty($params['questions']) && $lesson->id) {
            $questions = [];
            foreach($params['questions'] as $key => $question ) {
                array_push($questions, [
                    "question_id" => $question['id'],
                    "lesson_id" => $lesson->id,
                    'order_number'=> $key
                ] );
            }
            LessonDetails::insert($questions);
        }

        return response([
            'message' => 'Lesson successfully created',
            'lesson' => $lesson
        ], 201);
    }

    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'string|between:2,255',
            'description' => 'string|nullable',
            'image' => 'string|nullable',
            'order_number' => 'int|min:0',
        ]);

        if($validator->fails()){
            return response(["errors" => $validator->errors()], 400);
        }

        $lesson = Lesson::find($id);

        if(!$lesson) {
            return response(["errors" => "Not found lesson with {$id}"], 400);
        }
     
		if(isset($params['name'])) $lesson->name = $params['name'];
        if(isset($params['description'])) $lesson->description = $params['description'];
		if(isset($params['image'])) $lesson->image = $params['image'];
		if(isset($params['order_number'])) $lesson->order_number = (int) $params['order_number'];

        $lesson->save();

        LessonDetails::where('lesson_id', $id)->delete();

        if(!empty($params['questions'])) {
            $questions = [];
            foreach($params['questions'] as $key => $question) {
                array_push($questions, [
                    "question_id" => $question['id'],
                    "lesson_id" => $lesson->id,
                    'order_number'=> $key

                ] );
            }
            LessonDetails::insert($questions);
        }

        return response([
            'message' => 'Lesson successfully edited',
            'lesson' => $lesson
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response(["errors" => "Not found id"], 400);
        }

        $data = Lesson::find($id);

        if(!$data) {
            return response(["errors" => "Not found lesson with {$id}"], 400);
        }

        $data->delete();

        return response([
            'message' => 'Lesson successfully deleted',
            'lesson' => $data
        ], 200);
    }


}