<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\InvoiceDetails;
use Validator;

class InvoiceDetailsController extends Controller
{
    public function getDetails(Request $request, $invoice_id) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
        $note = isset($request['note']) ? $request['note'] : '';
        $status = !empty($request['status']) ? $request['status'] : 0;

        $data = null;
        
        $invoiceDetails = InvoiceDetails::where('invoice_id',$invoice_id)
            ->where('note', 'like', "%{$note}%");
        if($status) {
            $invoice = $invoice->where('invoice.status', $status);
        }
        if(!$limit)
            $data = $invoiceDetails->get();
        else
            $data = $invoiceDetails->paginate($limit)->withQueryString();

        if(!is_array($data)) {
            $data = $data->toArray();
        }
        
        return response(['invoice_details' => $data, 'result' => 'Success', 'error_message' => null]);
    }

    public function getID(Request $request, $id) {
        if(!$id) 
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$id}" ],400);
        $data = InvoiceDetails::find($id);
        if($data)
            return response(['invoice_detail' => $data, 'result' => 'Success', 'error_message' => null]);
        else
            return response([ 'result' => 'error', 'error_message' => "Not found ID {$id}"], 400);
     }
}