<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Lesson;
use App\Models\EnglishBookDetails;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class EnglishBookDetailsController extends Controller
{
    public function index(Request $request) {
      $params = $request->all();
      $page = !empty($params['page']) ? $params['page'] : 1;
      $limit = !empty($request['limit']) ? $request['limit'] : 0;
      $englishBookID = !empty($request['english_book_id']) ? $request['english_book_id'] : '';
      $orderField = !empty($request['order_field']) ? $request['order_field'] : 'order_number';
      $orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'asc';
      $data = null;

      $englishBookDetails = EnglishBookDetails::with('lesson')->orderBy($orderField, $orderDirection);
      
      if($englishBookID) 
          $englishBookDetails = $englishBookDetails->where('english_book_id', $englishBookID);
  
      if(!$limit) 
        $data = ["data" => $englishBookDetails->get()];
      else
        $data = $englishBookDetails->paginate($limit)->withQueryString();
      return response($data);
    }



}
