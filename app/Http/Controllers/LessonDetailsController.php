<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Lesson;
use App\Models\LessonDetails;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class LessonDetailsController extends Controller
{
    public function index(Request $request) {
      $params = $request->all();
      $page = !empty($params['page']) ? $params['page'] : 1;
      $limit = !empty($request['limit']) ? $request['limit'] : 0;
      $lesson_id = !empty($request['lesson_id']) ? $request['lesson_id'] : '';
      $orderField = !empty($request['order_field']) ? $request['order_field'] : 'order_number';
		  $orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'asc';
      $data = null;
      $lessonDetails = LessonDetails::where('lesson_id', $lesson_id)
        ->with('question')
        ->orderBy($orderField, $orderDirection);
  
      if(!$limit) 
        $data = ["data" => $lessonDetails->get()];
      else 
        $data = $lessonDetails->paginate($limit)->withQueryString();

      if(!is_array($data)) {
        $data = $data->toArray();
      }     
      
      if(!empty($data['data'])) {
        foreach ($data['data'] as &$item) {
          $description_arr = explode("\n", $item['question']['description']);
          $item['question']['description_arr'] = array_filter($description_arr);
        }
      }
    
        
      return response($data);
    }



}