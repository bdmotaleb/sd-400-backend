<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $invoice = Invoice::with(['user' => function ($q) {
            $q->select('id', 'name');
        }, 'member'                      => function ($q) {
            $q->select('member_id', 'name', 'mobile');
        }])->orderBy('id', 'DESC')->get();

        return success_response($invoice);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "member_id"    => "required",
            "date"         => "required",
            "amount"       => "required",
            "fee_type"     => "required",
            "payment_type" => "required",
        ]);

        # Check validation
        if ($validator->fails()) return validation_error($validator->errors());

        try {
            $invoice = Invoice::create([
                'member_id'    => $request->member_id,
                'start_date'   => $request->date['from'],
                'end_date'     => $request->date['to'],
                'amount'       => $request->amount,
                'fee_type'     => $request->fee_type['value'],
                'payment_type' => $request->payment_type['value'],
                'create_by'    => auth()->id(),
            ]);

            $data = Invoice::with('user', 'member')->find($invoice->id);

            return success_response($data, __('message.invoice.create.success'), 201);
        } catch (Exception $e) {
            return error_response(__('message.invoice.create.error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $invoice = Invoice::with('user', 'member')->find($id);

        $invoice['name']   = $invoice->member['name'];
        $invoice['mobile'] = $invoice->member['mobile'];

        return $invoice ? success_response($invoice) : error_response(__('message.invoice.manage.not_found'), 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param         $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $validator = Validator::make($request->all(), [
                "member_id"    => "required",
                "start_date"   => "required|date_format:Y-m-d",
                "end_date"     => "required|date_format:Y-m-d",
                "amount"       => "required",
                "fee_type"     => "required",
                "payment_type" => "required",
            ]);

            # Check validation
            if ($validator->fails()) return validation_error($validator->errors());

            try {
                $invoice->member_id    = $request->member_id;
                $invoice->start_date   = $request->start_date;
                $invoice->end_date     = $request->end_date;
                $invoice->amount       = $request->amount;
                $invoice->fee_type     = $request->fee_type;
                $invoice->payment_type = $request->payment_type;
                $invoice->create_by    = auth()->id();
                $invoice->update();

                return success_response($invoice, __('message.expense.update.success'), 202);
            } catch (Exception $e) {
                return error_response(__('message.expense.update.error'));
            }
        } else {
            return error_response(__('message.expense.manage.not_found'), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->delete();
            return success_response([], __('message.invoice.manage.deleted'), 203);
        } else {
            return error_response(__('message.invoice.manage.not_found'), 404);
        }
    }
}
