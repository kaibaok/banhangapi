<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\DeviceFunc;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class DeviceFuncController extends Controller
{

    public function index(Request $request) {
      $params = $request->all();
      $page = !empty($params['page']) ? $params['page'] : 1;
      $limit = !empty($request['limit']) ? $request['limit'] : 0;
      $device_type_id = isset($request['device_type_id']) ? $request['device_type_id'] : '';
      $orderField = !empty($request['order_field']) ? $request['order_field'] : 'id';
      $orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'asc';
      $data = null;
      $devices = DeviceFunc::with('types_device')->orderBy($orderField, $orderDirection);
      if($device_type_id) 
        $devices = $devices->where('device_type_id', $device_type_id);

      if(!$limit) 
        $data = ["data" => $devices->get()];
      else
        $data = $devices->paginate($limit)->withQueryString();
      return response($data);
    }

    public function deviceFunc(Request $request, $id) {
        if(!$id) 
            return response(["error" => "Not found device func ID"],400);
        $data = DeviceFunc::find($id);
        if($data)
            return response(["data" => $data], 200);
        else
            return response(["error" => "Not found device func ID"], 400);
     }

    public function create(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
            'device_type_id' => 'required|int',
            'action' => 'string',
        ]);

        if($validator->fails()){
            return response(["errors" =>$validator->errors()], 400);
        }

        $data = DeviceFunc::create(array_merge(
            $validator->validated(),
        ));

        return response([
            'message' => 'Device Func successfully created',
            'device_func' => $data 
        ], 201);
    }
    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'required|string|between:2,255',
            'device_type_id' => 'required|int',
            'action' => 'string',
        ]);

        if($validator->fails()){
            return response(["errors" => $validator->errors()], 400);
        }

        $data = DeviceFunc::find($id);

        if(!$data) {
            return response(["errors" => "Not found device func with {$id}"], 400);
        }
     
        if(isset($params['name'])) $data->name = $params['name'];
        if(isset($params['action'])) $data->action = $params['action'];
        if(isset($params['device_type_id'])) $data->device_type_id = $params['device_type_id'];

        $data->save();
       
        return response([
            'message' => 'Device func successfully edited',
            'device_func' => $data
        ], 200);
    }
    public function delete(Request $request, $id) {
        if(!$id) {
            return response(["errors" => "Not found id"], 400);
        }

        $data = DeviceFunc::find($id);

        if(!$data) {
            return response(["errors" => "Not found device func with {$id}"], 400);
        }

        $data->delete();

        return response([
            'message' => 'Device func successfully deleted',
            'device func' => $data
        ], 200);
    }
}