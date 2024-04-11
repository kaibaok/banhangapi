<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Desk;
use Validator;

class DeskController extends Controller
{
    public function getPage(Request $request) {
		$limit = !empty($request['limit']) ? $request['limit'] : 30;
        $status = isset($request['status']) ? $request['status'] : 0;
        $name = isset($request['name']) ? $request['name'] : '';
        $results = Desk::where('name', 'like', "%{$name}%");
        if ($status) {
            $results = $results->where('status', '=', $status);
        }
        $data = $results->paginate($limit)->withQueryString()->toArray();

        return response(['desks' => $data, 'result' => 'Success', 'error_message' => null]);
    }

    public function getID(Request $request, $id)
    {
        if (!$id)
            return response(['result' => 'error', 'error_message' => "Not found ID {$id}"], 400);
        $data = Desk::find($id);
        if ($data)
            return response(['desk' => $data, 'result' => 'Success', 'error_message' => null]);
        else
            return response(['result' => 'error', 'error_message' => "Not found ID {$id}"], 400);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
            'status' => 'int',
        ]);

        if ($validator->fails()) {
            return response([
                'result' => 'error',
                "error_message" => $validator->errors()
            ], 400);
        }

        $result = Desk::create(array_merge(
            $validator->validated(),
        ));

        return response([
            'result' => 'Success',
            'error_message' => null,
            'desk' => $result
        ], 201);
    }

    public function edit(Request $request, $id)
    {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'required|string|between:2,255',
            'status' => 'int',
        ]);

        if ($validator->fails()) {
            return response([
                'result' => 'error',
                "error_message" => $validator->errors()
            ], 400);
        }

        $result = Desk::find($id);

        if (!$result) {
            return response(['result' => 'error', "error_message"  => "Not found ID {$id}"], 400);
        }

        if (isset($params['name'])) $result->name = $params['name'];
        if (isset($params['status'])) $result->status = $params['status'];
        if(isset($params['create_at'])) $result->create_at = $params['create_at'];
        if(isset($params['update_at'])) $result->update_at = $params['update_at'];
        
        $result->save();

        return response([
            'result' => 'Success',
            'error_message' => null,
            'desk' => $result
        ], 200);
    }


    public function delete(Request $request, $id)
    {
        if (!$id) {
            return response(['result' => 'error', "error_message"  => "Not found ID {$id}"], 400);
        }

        $data = Desk::find($id);

        if (!$data) {
            return response(['result' => 'error', "error_message" => "Not found ID {$id}"], 400);
        }

        $data->delete();

        return response([
            'result' => 'Success',
            'error_message' => null,
            'data' => $data
        ], 200);
    }
}