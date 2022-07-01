<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $expense = Expense::with(['user' => function ($q) {
            $q->select('id', 'name');
        }])->select('id', 'name', 'amount', 'date', 'type', 'create_by', 'created_at')->orderBy('id', 'DESC')->get();

        return success_response($expense);
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
            "name"   => "required|max:200",
            "amount" => "required",
            "date"   => "required",
            "type"   => "required",
        ]);

        # Check validation
        if ($validator->fails()) return validation_error($validator->errors());

        try {
            $expense = Expense::create([
                'name'      => $request->name,
                'amount'    => $request->amount,
                'date'      => $request->date,
                'type'      => $request->type,
                'create_by' => auth()->id(),
            ]);
            return success_response($expense, __('message.expense.create.success'), 201);
        } catch (Exception $e) {
            return error_response(__('message.expense.create.error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $expense = Expense::find($id);
        $expense->date = date('Y/m/d', strtotime($expense->date));

        return $expense ? success_response($expense) : error_response(__('message.expense.manage.not_found'), 404);
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
        $expense = Expense::find($id);

        if ($expense) {
            $validator = Validator::make($request->all(), [
                "name"   => "required|max:200",
                "amount" => "required",
                "date"   => "required",
                "type"   => "required",
            ]);

            # Check validation
            if ($validator->fails()) return validation_error($validator->errors());

            try {
                $expense->name      = $request->name;
                $expense->amount    = $request->amount;
                $expense->date      = $request->date;
                $expense->type      = $request->type;
                $expense->create_by = auth()->id();
                $expense->update();

                return success_response($expense, __('message.expense.update.success'), 202);
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
        $expense = Expense::find($id);
        if ($expense) {
            $expense->delete();
            return success_response([], __('message.expense.manage.deleted'), 203);
        } else {
            return error_response(__('message.expense.manage.not_found'), 404);
        }
    }
}
