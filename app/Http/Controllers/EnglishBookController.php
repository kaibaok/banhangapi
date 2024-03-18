<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\EnglishBook;
use App\Models\EnglishBookDetails;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class EnglishBookController extends Controller
{

    public function index(Request $request) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
        $orderField = !empty($request['order_field']) ? $request['order_field'] : 'id';
		$orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'desc';
		$name = !empty($request['name']) ? $request['name'] : '';
		$data = null;
        $englishBook = EnglishBook::where('name', 'like', "%${name}%")->orderBy($orderField, $orderDirection);
		if(!$limit) 
			$data = ["data" => $englishBook->get()];
		else
			$data = $englishBook->paginate($limit)->withQueryString();
		return response($data);
    }
	
    public function englishBook(Request $request, $id) {
        if(!$id) 
            return response(["error" => "Not found book ID"],400);
        $data = EnglishBook::find($id);
        if($data)
            return response(["data" => $data], 200);
        else
            return response(["error" => "Not found book ID"], 400);
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

        $book = EnglishBook::create(array_merge(
            $validator->validated(),
        ));

        EnglishBookDetails::where('english_book_id', $book->id)->delete();

        if(!empty($params['lessons']) && $book->id) {
            $lessons = [];
            foreach($params['lessons'] as $key => $lesson) {
                array_push($lessons, [
                    "english_book_id" => $book->id,
                    "lesson_id" => $lesson['id'],
                    "order_number" => $key,
                ] );
            }
            EnglishBookDetails::insert($lessons);
        }

        return response([
            'message' => 'english book successfully created',
            'english_book' => $book
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

        $book = EnglishBook::find($id);

        if(!$book) {
            return response(["errors" => "Not found book with {$id}"], 400);
        }
     
		if(isset($params['name'])) $book->name = $params['name'];
		if(isset($params['description'])) $book->description = $params['description'];
		if(isset($params['image'])) $book->image = $params['image'];
		if(isset($params['order_number'])) $book->order_number = (int) $params['order_number'];

        $book->save();

        EnglishBookDetails::where('english_book_id', $id)->delete();

        if(!empty($params['lessons'])) {
            $lessons = [];
            foreach($params['lessons'] as $key => $lesson) {
                array_push($lessons, [
                    "english_book_id" => $book->id,
                    "lesson_id" => $lesson['id'],
                    "order_number" => $key,
                ] );
            }
            EnglishBookDetails::insert($lessons);
        }
       
        return response([
            'message' => 'book successfully edited',
            'english_book' => $book
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response(["errors" => "Not found id"], 400);
        }

        $data = EnglishBook::find($id);

        if(!$data) {
            return response(["errors" => "Not found book with {$id}"], 400);
        }

        $data->delete();

        return response([
            'message' => 'book successfully deleted',
            'english_book' => $data
        ], 200);
    }

}