<?php

namespace App\Modules\Accounts\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\Expense;
use App\Modules\Accounts\Models\ExpenseCategory;
use App\Modules\Accounts\Models\ExpenseSubCategory;
use App\Modules\Accounts\Models\TransactionHistory;
use App\Modules\BankAccount\Models\BankAccount;
use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Comment;
use PhpParser\Node\Expr\Array_;

class ExpenseController extends Controller
{

    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Expense';
        $common_data->page_title = 'Expense';


        $expenses = Expense::when(myBranchOrNull(),function($q){
            $q->where('branch_id',myBranchOrNull());
        })
        ->where('deleted', 0)->get();
        $branches = Branch::where(['status' => 1, 'deleted' => 0])->get();
        $categories = ExpenseCategory::where(['status' => 1, 'deleted' => 0])->get();
        return view("Accounts::expense.index")
            ->with(compact(
                'common_data',
                'expenses',
                'categories',
                'branches'
            ));

    }

    public function store(Request $request)
    {


        $validator = $request->validate([
            'expense_category_id' => 'required',
            'expense_sub_category_id' => 'required',
            'employee_id' => 'required',
            'datetime' => 'required',
            'amount' => 'required',
            'bank_account_id' => 'required',
            'note' => 'nullable'
        ]);

        if (isAdmin()) {
            $request->validate([
                'branch_id' => 'required']);
        }


        DB::beginTransaction();

        try {
            $data = $validator;
            $data['status'] = 1;
            $data['created_at'] = Carbon::now();
            $data['created_by'] = Auth::id();
            $data['deleted'] = 0;
            if (!isAdmin()) {
                $data['branch_id'] = myBranchId();
            }

            $exp = Expense::create($data);

            $transaction = new TransactionHistory();
            $transaction->type = 'out';
            $transaction->type_description = 'Expense Entry';
            $transaction->branch_id = requestOrUserBranch($request->branch_id);
            $transaction->bank_account_id = $request->bank_account_id;
            $transaction->reference = 'expense';
            $transaction->reference_id = $exp->id;
            $transaction->datetime = $request->datetime;
            $transaction->amount = $request->amount;
            $transaction->note = $request->note;
            $transaction->status = 1;
            $transaction->save();
            $transaction->transaction_no = 1000 + $transaction->id;
            $transaction->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();


        return redirect()->back()->with(['success' => 'Expense Added Successfully']);
    }

    public function edit($id)
    {
        $expense = Expense::where('id', $id)->first();
        $branches = Branch::where(['deleted' => 0, 'status' => 1])->get();
        $employees = Employee::where('branch_id', $expense->branch_id)->where(['deleted' => 0, 'status' => 1])->get();
        $subcategories = ExpenseSubCategory::where(['deleted' => 0, 'status' => 1])->get();
        $categories = ExpenseCategory::where(['deleted' => 0, 'status' => 1])->get();


        if (empty($expense)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Expense'
            ]);
        }
        $view = view("Accounts::expense._expense_data")->with(compact('expense', 'branches', 'employees', 'subcategories', 'categories'))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validator = $request->validate([
                'expense_category_id' => 'required',
                'expense_sub_category_id' => 'required',
                'employee_id' => 'required',
                'datetime' => 'required',
                'amount' => 'required',
                'note' => 'nullable',
            ]);

            if (isAdmin()) {
                $request->validate([
                    'branch_id' => 'required']);
            }
            $expense = Expense::find($id);

            $data = $validator;
            $data['status'] = 1;
            $data['updated_at'] = Carbon::now();
            $data['updated_by'] = Auth::id();
            $data['deleted'] = 0;

            $expense->update($data);
            $transaction = TransactionHistory::where('reference', 'expense')
                ->where('reference_id', $expense->id)
                ->first();
            if (!empty($transaction)) {

                $transaction->branch_id = requestOrUserBranch($request->branch_id);
                $transaction->datetime = $request->datetime;
                $transaction->amount = $request->amount;
                $transaction->note = $request->note;
                $transaction->save();
            }


        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();
        return redirect()->back()->with(['success' => 'Expense Update Successs']);
    }

    public function updateStatus($id, $status)
    {
        try {
            $expense = Expense::where('id', $id)
                ->first();
            if (empty($expense)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Branch'
                ]);
            }

            $expense->status = $status;
            $expense->save();
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

    public function getEmployee(Request $request)
    {

        $employees = Employee::where('branch_id', $request->branch_id)->where(['deleted' => 0, 'status' => 1])->get();
        $banks = BankAccount::where(['deleted'=>0,'branch_id'=>requestOrUserBranch($request->branch_id)])->get();
        $empList=view('Accounts::expense._employee_list')->with(compact('employees'))->render();
        $bankListData=view('Accounts::expense._bank_list')->with(compact('banks'))->render();

         return [$empList,$bankListData];
    }

    public function getSubcategory(Request $request)
    {


        $subcategories = ExpenseSubCategory::where('expense_category_id', $request->category_id)->where(['deleted' => 0, 'status' => 1])->get();

        return view('Accounts::expense._subcategory_list')->with(compact('subcategories'))->render();
    }

}
