<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Devices;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class DevicesController extends Controller
{

   public function index(Request $request) {
        $params = $request->all();
        $page = !empty($params['page']) ? $params['page'] : 1;
        $limit = !empty($request['limit']) ? $request['limit'] : 0;
        $orderField = !empty($request['order_field']) ? $request['order_field'] : 'id';
		$orderDirection = !empty($request['order_direction']) ? $request['order_direction'] : 'desc';
		$name = !empty($request['name']) ? $request['name'] : '';
        $devices = null;
        $data = null;
        $devices =  Devices::where('name', 'like', "%${name}%")->orderBy($orderField, $orderDirection);

        if(!$limit)
            $data = ["data" => $devices->get()->toArray()];
        else
            $data = $devices->paginate($limit)->withQueryString()->toArray();
            
        if(count($data['data']) > 0 ) {
            foreach($data['data'] as &$device) {
                $device['status'] = false;
            }
        }
        return response($data);
    }


    public function device(Request $request, $id) {
        if(!$id) 
            return response(["error" => "Not found device ID"],400);
        $device = Devices::find($id);
        if($device)
            return response(["data" => $device], 200);
        else
            return response(["error" => "Not found device ID"], 400);
     }

    public function create(Request $request) {
        $validator = Validator::make($request->json()->all(), [
            'name' => 'required|string|between:2,255',
            'device_type' => 'nullable|min:0',
            'func_id' => 'nullable|min:0',
            "description" => "nullable|string",
            "ip_address" => "nullable|string",
            "ip_address_output" => "nullable|string",
            'is_input_device' => 'nullable|min:0',
            'area_id' => 'nullable|min:0',
        ]);

        if($validator->fails()){
            return response(["errors" =>$validator->errors()], 400);
        }

        $params = array_merge( $validator->validated() );
        $params['device_type'] = isset($params['device_type']) ? (int) $params['device_type'] : 0;
        $params['func_id'] = isset($params['func_id']) ? (int) $params['func_id'] : 0;
        $params['is_input_device'] = isset($params['is_input_device']) ? (int) $params['is_input_device'] : 0;
        $params['area_id'] = isset($params['area_id']) ? (int) $params['area_id'] : 0;

        $devices = Devices::create($params);

        return response([
            'message' => 'Device successfully created',
            'devices' => $devices
        ], 201);
    }

    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'name' => 'string|between:2,255',
            'device_type' => 'nullable|min:0',
            'func_id' => 'nullable|min:0',
            "ip_address" => "nullable|string",
            "ip_address_output" => "nullable|string",
            "is_input_device" => "nullable|min:0",
            "area_id" => "nullable|min:0",
        ]);

        if($validator->fails()){
            return response(["errors" => $validator->errors()], 400);
        }

        $devices = Devices::find($id);

        if(!$devices) {
            return response(["errors" => "Not found device with {$id}"], 400);
        }

        $devices->name = $params['name'];
        
        if(isset($params['device_type'])) $devices->device_type = (int) $params['device_type'];
        if(isset($params['func_id'])) $devices->func_id = (int) $params['func_id'];
        if(isset($params['ip_address'])) $devices->ip_address = $params['ip_address'];
        if(isset($params['ip_address_output'])) $devices->ip_address_output = $params['ip_address_output'];
        if(isset($params['description'])) $devices->description = $params['description'];
        if(isset($params['is_input_device'])) $devices->is_input_device = (int) $params['is_input_device'];
        if(isset($params['area_id'])) $devices->area_id = (int) $params['area_id'];

        $devices->save();
       
        return response([
            'message' => 'Device successfully edited',
            'devices' => $devices
        ], 200);
    }


    public function delete(Request $request, $id) {
        if(!$id) {
            return response(["errors" => "Not found id"], 400);
        }

        $devices = Devices::find($id);

        if(!$devices) {
            return response(["errors" => "Not found device with {$id}"], 400);
        }

        $devices->delete();

        return response([
            'message' => 'Device successfully deleted',
            'devices' => $devices
        ], 200);
    }

    public function ping(Request $request) {
        $params = $request->json()->all();
        $ip = !empty($params['ip_address']) ? $params['ip_address'] : '';
        if($ip) {
            try{
                $response = Http::timeout(2)->withOptions(['verify' => false])->get($ip);
                return $response->successful();
            }
            catch(\Illuminate\Http\Client\ConnectionException $ex) {
                return response(["error" => "IP ADDRESS NOT WORKING"],500);
            }
            catch(\GuzzleHttp\Exception\ConnectException $ex){
                return response(["error" => "IP ADDRESS NOT WORKING"],500);
            }
            catch(\GuzzleHttp\Exception\RequestException $e) {
                return response(["error" => "IP ADDRESS NOT WORKING"],500);
            }
        }
        return response(["error" => "Not found IP ADDRESS"],400);
    }

    protected function testIP($ip){
        try{
            if($ip) {
                $response = Http::timeout(1)->get($ip);
                return response($response);
            }
        }
        catch(\Illuminate\Http\Client\ConnectionException $ex) {
            return response(["error" => "IP ADDRESS NOT WORKING"],500);
        }
        catch(\GuzzleHttp\Exception\ConnectException $ex){
            return response(["error" => "IP ADDRESS NOT WORKING"],500);
        }
        catch(\GuzzleHttp\Exception\RequestException $e) {
            return response(["error" => "IP ADDRESS NOT WORKING"],500);
        }
        return response(["error" => "Not found IP ADDRESS"],400);
    }

    public function action(Request $request, $id) {
        $params = $request->all();
        if(!$id) 
            return response(["error" => "Not found device ID"],400);
        $device = Devices::find($id);
        if(!$device) 
            return response(["error" => "Not found device ID"],400);

        $ip = $device->ip_address;

        if($ip) {
            try{
                $action = !empty($params['action']) ? $params['action'] : '';
                $response = Http::timeout(1)->get( $ip .'/'.$action);
                return $response;
            }
            catch(\Illuminate\Http\Client\ConnectionException $ex) {
                return response(["error" => "IP ADDRESS NOT WORKING"],500);
            }
            catch(\GuzzleHttp\Exception\ConnectException $ex){
                return response(["error" => "IP ADDRESS NOT WORKING"],500);
            }
            catch(\GuzzleHttp\Exception\RequestException $e) {
                return response(["error" => "IP ADDRESS NOT WORKING"],500);
            }
        }
        return response(["error" => "Not found IP ADDRESS"],400);

    }

    public function test() {
        return response(["message" => "aaaaa"],200);
    }
}