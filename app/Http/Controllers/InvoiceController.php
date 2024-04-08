<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use Validator;


class InvoiceController extends Controller
{
    public function index(Request $request) {
        $limit = !empty($request['limit']) ? $request['limit'] : 30;
        $status = !empty($request['status']) ? $request['status'] : 0;
        $delivery = !empty($request['delivery']) ? $request['delivery'] : 0;
        $table_id = !empty($request['table_id']) ? $request['table_id'] : 0;
        $user_id = !empty($request['user_id']) ? $request['user_id'] : 0;
        $customer_id = !empty($request['customer_id']) ? $request['customer_id'] : 0;
        $staff_name = !empty($request['staff_name']) ? $request['staff_name'] : '';
        $customer_name = !empty($request['customer_name']) ? $request['customer_name'] : '';
        $note = !empty($request['note']) ? $request['note'] : '';
        $data = null;

        $invoice = DB::table('invoice')
            ->selectRaw("invoice.*, user.username as staff_name, customer.full_name as customer_name")            
            ->join('user', 'invoice.user_id','=', 'user.id')
            ->join('customer', 'invoice.customer_id', '=', 'customer.id')
            ->join('user_info', 'user.id','=', 'user_info.user_id')
            ->where('invoice.note' ,'like', "%{$note}%")
            ->where('user_info.full_name' ,'like', "%{$staff_name}%")
            ->where('customer.full_name' ,'like', "%{$customer_name}%");
        

        if($status) {
            $invoice = $invoice->where('invoice.status', $status);
        }
        if($delivery) {
            $invoice = $invoice->where('invoice.delivery', $delivery);
        }
        if($table_id) {
            $invoice = $invoice->where('invoice.table_id', $table_id);
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

    public function create(Request $request) {
        $params = $request->json()->all();
        
        $validator = Validator::make($params, [
            'customer_id' => 'required|int',
            'vat' => 'int',
            'note' => 'string',
            'status' => 'int',
            'delivery' => 'int',
            'table_id' => 'int',
            'user_id' => 'int',
            'discount' => 'int',
            'invoice_details' => '',
        ]);

        if($validator->fails()){
            return response([
                'result' => 'error',
                "error_message" => $validator->errors()
            ], 400);
        }
        
        $invoice_details = !empty($params['invoice_details']) ? $params['invoice_details'] : [];
        $result = Invoice::create(array_merge($validator->validated()));
       
        if($result && !empty($invoice_details)) {
            $dataUpdate = [];
            foreach($invoice_details as &$invoice_detail) {
                if(!empty($invoice_detail['food_id'])) {
                    $invoice_detail['invoice_id'] = $result->id;
                    array_push($dataUpdate, $invoice_detail);
                }
            }
            InvoiceDetails::insert($dataUpdate);
        }

        return response([
                'result' => 'success',
                'error_message' => null,
                'data' => $result
            ], 201
        );
    }


    public function edit(Request $request, $id) {
        $params = $request->json()->all();
        $validator = Validator::make($params, [
            'customer_id' => 'required|int',
            'vat' => 'int',
            'note' => 'string',
            'status' => 'int',
            'delivery' => 'int',
            'table_id' => 'int',
            'user_id' => 'int',
            'discount' => 'int',
            'invoice_details' => '',
        ]);

        if ($validator->fails()) {
            return response([
                'result' => 'error',
                "error_message" => $validator->errors()
            ], 400);
        }

        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response([
                'result' => 'error',
                'error_message' => "Not found with {$id}"
            ], 400);
        }

        if (isset($params['customer_id'])) $invoice->customer_id = $params['customer_id'];
        if (isset($params['vat'])) $invoice->vat = $params['vat'];
        if (isset($params['note'])) $invoice->note = $params['note'];
        if (isset($params['status'])) $invoice->status = $params['status'];
        if (isset($params['delivery'])) $invoice->delivery = $params['delivery'];
        if (isset($params['table_id'])) $invoice->table_id = $params['table_id'];
        if (isset($params['user_id'])) $invoice->user_id = $params['user_id'];
        if (isset($params['discount'])) $invoice->discount = $params['discount'];

        $invoice->save();

        $invoice_details = !empty($params['invoice_details']) ? $params['invoice_details'] : [];

        if ($invoice && !empty($invoice_details)) {
            InvoiceDetails::where('invoice_id', '=', $id)->delete();
            $dataUpdate = [];
            foreach ($invoice_details as &$invoice_detail) {
                if (!empty($invoice_detail['food_id'])) {
                    $invoice_detail['invoice_id'] = $id;
                    array_push($dataUpdate, $invoice_detail);
                }
            }
            InvoiceDetails::insert($dataUpdate);
        }

        return response([
            'result' => 'success',
            'error_message' => null,
            'data' => $invoice
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        if (!$id) {
            return response(['result' => 'error', "error_message"  => "Not found ID {$id}"], 400);
        }

        $data = Invoice::find($id);

        if (!$data) {
            return response(['result' => 'error', "error_message" => "Not found ID {$id}"], 400);
        }

        $data->delete();
        InvoiceDetails::where('invoice_id', '=', $id)->delete();

        return response([
            'result' => 'success',
            'error_message' => null,
            'data' => $data
        ], 200);
    }
}