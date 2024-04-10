<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\InvoiceDetails;
use Validator;

class InvoiceDetailsController extends Controller
{
    public function index(Request $request, $invoice_id) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
        $note = isset($request['note']) ? $request['note'] : '';
        
        $data = null;
        
        $invoiceDetails = InvoiceDetails::where('invoice_id',$invoice_id)
            ->where('note', 'like', "%{$note}%");

        if(!$limit)
            $data = $invoiceDetails->get();
        else
            $data = $invoiceDetails->paginate($limit)->withQueryString();

        if(!is_array($data)) {
            $data = $data->toArray();
        }
        
        return response(['data' => $data, 'result' => 'Success', 'error_message' => null]);
    }
}