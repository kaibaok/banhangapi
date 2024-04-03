<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Invoice;
use Validator;

class InvoiceController extends Controller
{
    public function index(Request $request) {
		$params = $request->all();
		$page = !empty($params['page']) ? $params['page'] : 1;
		$limit = !empty($request['limit']) ? $request['limit'] : 0;
        $note = isset($request['note']) ? $request['note'] : '';
        
        $data = null;
        
        $invoice = Invoice::where('note', 'like', "%{$note}%");

        if(!$limit)
            $data = $invoice->get();
        else
            $data = $invoice->paginate($limit)->withQueryString();

        if(!is_array($data)) {
            $data = $data->toArray();
        }

        return response(['data' => $data, 'result' => 'success', 'error_message' => null]);
    }
}