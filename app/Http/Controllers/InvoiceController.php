<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Invoice;
use Validator;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    public function index(Request $request) {
        $limit = !empty($request['limit']) ? $request['limit'] : 30;
        $status = !empty($request['status']) ? $request['status'] : 0;
        $delivery = !empty($request['delivery']) ? $request['delivery'] : 0;
        $table_number = !empty($request['table_number']) ? $request['table_number'] : 0;
        $user_id = !empty($request['user_id']) ? $request['user_id'] : 0;
        $customer_id = !empty($request['customer_id']) ? $request['customer_id'] : 0;
        $staff_name = !empty($request['staff_name']) ? $request['staff_name'] : '';
        $customer_name = !empty($request['customer_name']) ? $request['customer_name'] : '';
        $note = !empty($request['note']) ? $request['note'] : '';
        $data = null;

        $invoice = DB::table('invoice')
            ->selectRaw("invoice.*, user_info.full_name as staff_name, 
                customer.full_name as customer_name"
            )
            ->leftJoin('user', 'invoice.user_id', '=', 'user.id')
            ->leftJoin('customer', 'invoice.customer_id', '=', 'customer.id')
            ->join('user_info', 'user.id', '=', 'user_info.user_id')
            ->where('invoice.note' ,'like', "%{$note}%")
            ->where('user_info.full_name' ,'like', "%{$staff_name}%")
            ->where('customer.full_name' ,'like', "%{$customer_name}%");
        

        if($status) {
            $invoice = $invoice->where('invoice.status', $status);
        }
        if($delivery) {
            $invoice = $invoice->where('invoice.delivery', $delivery);
        }
        if($table_number) {
            $invoice = $invoice->where('invoice.table_number', $table_number);
        }
        if($user_id) {
            $invoice = $invoice->where('invoice.user_id', $user_id);
        }
        if($customer_id) {
            $invoice = $invoice->where('invoice.customer_id', $customer_id);
        }

        $data = $invoice->paginate($limit)->withQueryString()->toArray();

        return response(['data' => $data, 'result' => 'success', 'error_message' => null]);
    }
}