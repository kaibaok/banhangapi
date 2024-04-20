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

    public function getID(Request $request, $id) {

        if(!$id) 
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$id}" ],400);

        $data = DB::table('invoice_details')
            ->selectRaw("invoice_details.*, food.name as food_name")
            ->join('food', 'food.id', '=', 'invoice_details.food_id')
            ->first();

        if($data)
            return response(['invoice_detail' => $data, 'result' => 'Success', 'error_message' => null]);
        else
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$id}"], 400);
     }
}