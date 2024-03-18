<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\TypesDevice;
use App\Models\DeviceFunc;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class TypesDeviceController extends Controller
{

    public function index(Request $request) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
        $orderField = !empty($request['order_field']) ? $request['order_field'] : 'id';
		$orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'desc';
        $name = !empty($request['name']) ? $request['name']: '';
		$data = null;
        $typeDevice = TypesDevice::where('name','like', '%'.$name.'%' )
            ->orderBy($orderField, $orderDirection);
        if(!$limit) 
			$data = ["data" => $typeDevice->get()];
		else
			$data = $typeDevice->paginate($limit)->withQueryString();
		return response($data);
    }


    public function typesDevice(Request $request, $id) {
        if(!$id) 
            return response(["error" => "Not found types device ID"],400);
        $data = TypesDevice::find($id);
        if($data)
            return response(["data" => $data], 200);
        else
            return response(["error" => "Not found types device ID"], 400);
     }

    public function create(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
        ]);

        if($validator->fails()){
            return response(["errors" =>$validator->errors()], 400);
        }

        $devices = TypesDevice::create(array_merge(
            $validator->validated(),
        ));

        return response([
            'message' => 'Types device successfully created',
            'types_device' => $devices
        ], 201);
    }

    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'string|between:2,255',
        ]);

        if($validator->fails()){
            return response(["errors" => $validator->errors()], 400);
        }

        $data = TypesDevice::find($id);

        if(!$data) {
            return response(["errors" => "Not found types device with {$id}"], 400);
        }
     
		if(isset($params['name'])) $data->name = $params['name'];

        $data->save();
       
        return response([
            'message' => 'Types device successfully edited',
            'types_device' => $data
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response(["errors" => "Not found id"], 400);
        }

        $data = TypesDevice::find($id);

        if(!$data) {
            return response(["errors" => "Not found types device with {$id}"], 400);
        }

        $data->delete();

        DeviceFunc::where('device_type_id', $id)->delete();

        return response([
            'message' => 'Types device successfully deleted',
            'types_device' => $data
        ], 200);
    }

}