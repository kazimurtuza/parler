<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\Expense;
use App\Modules\Accounts\Models\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

class ExpenseCategoryController extends Controller
{

    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Expense Category';
        $common_data->page_title = 'Expense Category';

        $expense_categories = ExpenseCategory::where('deleted', 0)->get();
        return view("Accounts::expense_category.index")
            ->with(compact(
                'common_data',
                'expense_categories'
            ));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required',
        ]);

        $data = $validator;
        $data['status'] = 1;
        $data['created_at'] = Carbon::now();
        $data['created_by'] = Auth::id();
        $data['deleted'] = 0;


        ExpenseCategory::create($data);

        return redirect()->back()->with(['success' => 'Category Added Success']);
    }

    public function edit($id)
    {
        $expense_category = ExpenseCategory::where('id', $id)
            ->first();
        if (empty($expense_category)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid category'
            ]);
        }

        $view = view("Accounts::expense_category._edit_category_data")->with(compact('expense_category'))->render();
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
            ]);

            $expense_category = ExpenseCategory::where('id', $id)
                ->first();
            if (empty($expense_category)) {
                return redirect()->back()->with(['failed' => 'Expense Category']);
            }
            $data = $validator;
            $expense_category->update($data);

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        return redirect()->back()->with(['success' => 'Expense Category Update Successfully']);
    }

    public function updateStatus($id, $status)
    {
        try {
            $category =ExpenseCategory::where('id', $id)
                ->first();
            if (empty($category)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Category'
                ]);
            }

            $category->status = $status;
            $category->save();
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
