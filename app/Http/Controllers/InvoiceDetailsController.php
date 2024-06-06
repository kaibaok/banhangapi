<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\InvoiceDetails;
use Validator;

class InvoiceDetailsController extends Controller
{
    public function getDetails(Request $request, $invoice_id) {
		$limit = !empty($request['limit']) ? $request['limit'] : 30;
        $status = !empty($request['status']) ? $request['status'] : 0;

        $data = null;

        $invoiceDetails = DB::table('invoice_details')
            ->selectRaw("invoice_details.*, food.name as food_name")
            ->join('food', 'food.id', '=', 'invoice_details.food_id')
            ->where('invoice_details.invoice_id', $invoice_id);

        $data = $invoiceDetails->paginate($limit)->withQueryString()->toArray();
        
        return response(['invoice_details' => $data, 'result' => 'Success', 'error_message' => null]);
    }

    public function getID(Request $request, $invoice_detail_id) {

        if(!$invoice_detail_id) 
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$invoice_detail_id}" ],400);

        $data = DB::table('invoice_details')
            ->selectRaw("invoice_details.*, food.name as food_name")
            ->join('food', 'food.id', '=', 'invoice_details.food_id')
            ->first();

        if($data)
            return response(['invoice_detail' => $data, 'result' => 'Success', 'error_message' => null]);
        else
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$invoice_detail_id}"], 400);
     }

     public function edit(Request $request, $invoice_detail_id)
     {
         $params = $request->json()->all();
         $validator = Validator::make($params, [
             'status' => 'int|nulable',
             'discount' => 'int|nulable',
             'food_id' => 'int|nulable',
             'quantity' => 'int|nulable',
             'price' => 'int|nulable',
             'note' => 'string|nulable',
         ]);
 
         if ($validator->fails()) {
             return response([
                 'result' => 'error',
                 "error_message" => $validator->errors()
             ], 400);
         }
 
         $result = InvoiceDetails::find($invoice_detail_id);
 
         if (!$result) {
             return response(['result' => 'error', "error_message"  => "Not found ID {$invoice_detail_id}"], 400);
         }
 
         if (isset($params['discount'])) $result->discount = $params['discount'];
         if (isset($params['food_id'])) $result->food_id = $params['food_id'];
         if (isset($params['quantity'])) $result->quantity = $params['quantity'];
         if (isset($params['price'])) $result->price = $params['price'];
         if (isset($params['status'])) $result->status = $params['status'];
         if (isset($params['note'])) $result->note = $params['note'];
         
         $result->save();
 
         return response([
             'result' => 'Success',
             'error_message' => null,
             'invoice_detail' => $result
         ], 200);
     }
     
     public function updateStatus(Request $request, $invoice_detail_id)
     {
         $params = $request->json()->all();
         $validator = Validator::make($params, [
             'status' => 'int',
         ]);
 
         if ($validator->fails()) {
             return response([
                 'result' => 'error',
                 "error_message" => $validator->errors()
             ], 400);
         }
 
         $result = InvoiceDetails::find($invoice_detail_id);
 
         if (!$result) {
             return response(['result' => 'error', "error_message"  => "Not found ID {$invoice_detail_id}"], 400);
         }
         if (isset($params['status'])) $result->status = $params['status'];
         
         $result->save();
 
         return response([
             'result' => 'Success',
             'error_message' => null,
             'invoice_detail' => $result
         ], 200);
     }
}