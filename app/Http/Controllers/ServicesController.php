<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Areas;
use App\Models\Devices;
use App\Models\DemoFunc;
use App\Models\TypeDemoFunc;
use App\Models\DeviceFunc;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ServicesController extends Controller
{

    public function index(Request $request) {
    }
    
    protected function deviceInput(Request $request) {
        $params = $request->all();
        $url = !empty($params['ip_address']) ? $params['ip_address']:'';
        $area = !empty($params['area']) ? $params['area']:'';
        
        if(!$ipAddress || !$area) {
            return response(['error' => 'Bad request ip_address or area'],400);
        } 

        $devices = Devices::with('area')
            ->with('device_func')
            ->rightJoin('areas', 'areas.id', 'devices.area_id')
            ->where('devices.ip_address', $ipAddress)
            ->where('areas.name', $area)
            ->get();
          

        if(!empty($devices)) {
            foreach($devices as $device) {
                $ipAddressOutput = $device->ip_address_output;
                $action = !empty($device->device_func) ? $device->device_func->action : '';
                if($ipAddressOutput && $action) {
                    try{
                        $response = Http::timeout(1)->withOptions(['verify' => false])->get( "http://".$ipAddressOutput .'/'.$action);
                        return $response;
                    }
                    catch(\Illuminate\Http\Client\ConnectionException $ex) {
                        return response(["error" => "Action not working"],500);
                    }
                    catch(\GuzzleHttp\Exception\ConnectException $ex){
                        return response(["error" => "Action not working"],500);
                    }
                    catch(\GuzzleHttp\Exception\RequestException $e) {
                        return response(["error" => "Action not working"],500);
                    }
                }
            }
        }

        return response(['error' => 'Bad request ip_address or area'], 400);
    }

    protected function deviceTestFunc(Request $request) {
        $params = $request->json()->all();

        $ipAddress = isset($params['ip_address']) ? $params['ip_address'] : '';
        $action = isset($params['action']) ? $params['action'] : '';

        if(!$ipAddress || !$action) {
            return response(["error" => "Bad request ip_address or action" ], 400);
        }

        try{
            $response = Http::timeout(1)->get( "http://".$ipAddress .'/'.$action);
            return $response;
        }
        catch(\Illuminate\Http\Client\ConnectionException $ex) {
            return response(["error" => "Action not working"],500);
        }
        catch(\GuzzleHttp\Exception\ConnectException $ex){
            return response(["error" => "Action not working"],500);
        }
        catch(\GuzzleHttp\Exception\RequestException $e) {
            return response(["error" => "Action not working"],500);
        }
    }

    protected function importDemoFunc(Request $request){
        $params = $request->all();

        $deviceTypeID = isset($params['device_type_id']) ? $params['device_type_id'] : '';
        $typeDemoFunc = isset($params['type_demo_func']) ? $params['type_demo_func'] : '';

        if($deviceTypeID && $typeDemoFunc) {
            $demoFuncs = DemoFunc::where('type_demo_func', $typeDemoFunc)->get(['name','action'])->toArray();
            if(!empty($demoFuncs)) {
                foreach($demoFuncs as &$demoFunc) {
                    $demoFunc['device_type_id'] = $deviceTypeID;
                }
                DeviceFunc::where('device_type_id', $deviceTypeID)->delete();
                DeviceFunc::insert($demoFuncs);
                return response(["message" => "Imported demo functions successfully"], 200);
            }
        }
        return response(["error" => "Bad request device_type_id or type_demo_func "],400);
    }
    
    protected function typeDemoFuncs(Request $request){
         $params = $request->all();
        $page = !empty($params['page']) ? $params['page'] : 1;
        $limit = !empty($request['limit']) ? $request['limit'] : 0;
        $demo_funcs = null;
        if(!$limit) {
            $demo_funcs = ["data" => TypeDemoFunc::all()];
        }
        else {
            $demo_funcs = TypeDemoFunc::paginate($limit)->withQueryString();
        }
        return response($demo_funcs);
    }
    
    protected function demoFuncs(Request $request){
         $params = $request->all();
        $page = !empty($params['page']) ? $params['page'] : 1;
        $limit = !empty($request['limit']) ? $request['limit'] : 0;
        $type_demo_func = !empty($request['type_demo_func']) ? $request['type_demo_func'] : 0;
        $demo_funcs = DemoFunc::where('type_demo_func', $type_demo_func);
        
        if(!$limit) 
            $data = ["data" => $demo_funcs->get()];
        else
            $data = $demo_funcs->paginate($limit)->withQueryString();
        return response($data);
      
    }

    protected function getDataNoCors(Request $request) {
        try{
            $params = $request->all();
            $url = !empty($params['url']) ? $params['url']:'';
            if($url) {
                $response = json_decode(file_get_contents($url));
                return $response;
            } else {
                return response(["error" => "Endpoint not working"],500);
            }
        }
        catch(\Illuminate\Http\Client\ConnectionException $ex) {
            return response(["error" => "Endpoint 1 not working"],500);
        }
        catch(\GuzzleHttp\Exception\ConnectException $ex){
            return response(["error" => "Endpoint 2 not working"],500);
        }
        catch(\GuzzleHttp\Exception\RequestException $e) {
            return response(["error" => "Endpoint 3 not working"],500);
        }
    }
}