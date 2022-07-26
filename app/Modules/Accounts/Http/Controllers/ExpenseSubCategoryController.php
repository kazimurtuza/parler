<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\ExpenseCategory;
use App\Modules\Accounts\Models\ExpenseSubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

class ExpenseSubCategoryController extends Controller
{

    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Subcategory';
        $common_data->page_title = 'Subcategory';

        $subcategories = ExpenseSubCategory::where('deleted', 0)->get();
        $categories=ExpenseCategory::where('deleted', 0)->get();
        return view("Accounts::expense_subcategory.index")
            ->with(compact(
                'common_data',
                'subcategories',
                'categories'
            ));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
            'expense_category_id' => 'required',
        ]);

        $data = $validator;
        $data['status'] = 1;
        $data['created_at'] = Carbon::now();
        $data['created_by'] = Auth::id();
        $data['deleted'] = 0;

        ExpenseSubCategory::create($data);

        return redirect()->back()->with(['success' => 'Subcategory Added Successfully']);
    }

    public function edit($id)
    {
        $subcategory = ExpenseSubCategory::where('id', $id)
            ->first();
        $categorys=ExpenseCategory::where('deleted',0)->get();
        if (empty($subcategory)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Subcategory'
            ]);
        }

        $view = view("Accounts::expense_subcategory._expense_subcategory_data")->with(compact('categorys','subcategory'))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = $request->validate([
                'name' => 'required',
                'expense_category_id' => 'required',
            ]);

            $expense = ExpenseSubCategory::where('id', $id)
                ->first();


            if (empty($expense)) {
                return redirect()->back()->with(['failed' => 'Invalid Subcategory']);
            }
            $data = $validator;
            $data['status'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['updated_by'] = Auth::id();
            $data['deleted'] = 0;
            $expense->update($data);

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        return redirect()->back()->with(['success' => 'Subcategory Updated Successfully']);
    }

    public function updateStatus($id, $status)
    {
        try {
            $subcategory =ExpenseSubCategory::where('id', $id)
                ->first();
            if (empty($subcategory)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Subcategory'
                ]);
            }

            $subcategory->status = $status;
            $subcategory->save();
            return response()->json([
                'status' => 200,
                'updated_status' => $status
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 500,
                'msg' => $exception->getMessage()
            ]);
        }
    }
}
