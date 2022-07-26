<?php

namespace App\Modules\ProductInventory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BranchProduct;
use App\Modules\Accounts\Models\Expense;
use App\Modules\Accounts\Models\ExpenseSubCategory;
use App\Modules\Accounts\Models\TransactionHistory;
use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\Employee;
use App\Modules\Product\Models\Product;
use App\Modules\ProductInventory\Models\ProductInventory;
use App\Modules\ProductRequisition\Models\ProductRequisition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class ProductInventoryController extends Controller
{

    public function storeInventory(Request $request)
    {
        DB::beginTransaction();

        try {
            $id = $request->requisition_id;
            $requisition = ProductRequisition::find($id);
            if ($requisition->approve_status != 1) {
                return redirect()->back()->with(['failed' => 'This requisition is not valid for purchase.']);
            }

            foreach ($requisition->details as $reqdata) {
                $product_inven = new ProductInventory();
                $product_inven->branch_id =$requisition->branch_id;
                $product_inven->transaction_type = 0;
                $product_inven->product_requisition_id = $requisition->id;
                $product_inven->product_requisition_details_id = $reqdata->id;
                $product_inven->employee_id = Auth::user()->id;
                $product_inven->product_id = $reqdata->product_id;
                $product_inven->quantity = $reqdata->quantity;
                $product_inven->status = 1;
                $product_inven->created_at = Carbon::now();
                $product_inven->created_by = Auth::user()->id;
                $product_inven->save();

                /*find branch product and update*/
                $branch_product = BranchProduct::where('branch_id', $requisition->branch_id)
                    ->where('product_id', $reqdata->product_id)
                    ->first();
                if (empty($branch_product)) {
                    $branch_product = new BranchProduct();
                    $branch_product->branch_id = $requisition->branch_id;
                    $branch_product->product_id = $reqdata->product_id;

                    $branch_product->used_qty = 0;
                    $previous_available_qty = 0;
                    $previous_total_qty = 0;
                } else {
                    $previous_available_qty = $branch_product->available_qty;
                    $previous_total_qty = $branch_product->total_qty;
                }
                $branch_product->available_qty = ($previous_available_qty + $reqdata->quantity);
                $branch_product->total_qty = ($previous_total_qty + $reqdata->quantity);
                $branch_product->save();
            }

            $requisition->approve_status = 3;
            $requisition->save();

            $purchase_sub_category = ExpenseSubCategory::where('is_product_purchase', 1)
                ->where('status', 1)
                ->first();
            if (empty($purchase_sub_category)) {
                $purchase_sub_category = ExpenseSubCategory::where('status', 1)->first();
            }
            $expense = new Expense();
            $expense->branch_id = $requisition->branch_id;
            $expense->expense_category_id = $purchase_sub_category->expense_category_id;
            $expense->expense_sub_category_id = $purchase_sub_category->id;
            $expense->employee_id = Auth::user()->employee->id;
            $expense->datetime = Carbon::now();
            $expense->amount = $requisition->total_amount;
            $expense->note = 'Expense From Product Purchase';
            $expense->purchase_requisition_id = $requisition->id;
            $expense->bank_account_id = $request->bank;
            $expense->status = 1;
            $expense->created_at = Carbon::now();
            $expense->created_by = Auth::id();
            $expense->deleted = 0;
            $expense->save();



            $transaction = new TransactionHistory();
            $transaction->type = 'out';
            $transaction->type_description = 'Product Purchase';
            $transaction->branch_id = $requisition->branch_id;
            $transaction->bank_account_id = $request->bank;
            $transaction->reference = 'expense';
            $transaction->reference_id = $expense->id;
            $transaction->datetime = Carbon::now();
            $transaction->amount = $requisition->total_amount;
            $transaction->note = 'Expense From Product Purchase';
            $transaction->status = 1;
            $transaction->save();
            $transaction->transaction_no = 1000 + $transaction->id;
            $transaction->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();


        return redirect()->back()->with(['success' => ' Product  Successfully purchased']);
    }

    public function productUse()
    {
        $common_data = new Array_();
        $common_data->title = 'Add Use Product ';
        $common_data->page_title = 'Add Use Product';
        $branches = Branch::where(['deleted' => 0, 'status' => 1])->get();
        $products = BranchProduct::get();
        $product_list = Product::where(['deleted' => 0, 'status' => 1])->get();
        $employees = Employee::where(['deleted' => 0, 'status' => 1, 'type' => 'staff'])->get();

        return view('ProductInventory::use_products')->with(compact('common_data', 'branches', 'products', 'employees', 'product_list'));
    }

    public function staffGet(Request $request)
    {
        $id = $request->id;
        $employee_list = Employee::with('user')
            ->where('branch_id', $id)
            ->where('deleted', 0)
            ->get();
        return $employee_list;
    }

    public function sotreUseproduct(Request $request)
    {

        $request->validate([
            'product_id' => 'required',
            'employee_id' => 'required',
            'qty' => 'required',
        ]);
        if(isAdmin()){
            $request->validate([
                'branch_id' => 'required',
                ]);
        }
        DB::beginTransaction();
        try {
            $inventory = new ProductInventory;
            $inventory->branch_id = requestOrUserBranch($request->branch_id) ;
            $inventory->product_id = $request->product_id;
            $inventory->employee_id = $request->employee_id;
            $inventory->transaction_type = 1;
            $inventory->quantity = $request->qty;
            $inventory->save();

            $branchproduct = BranchProduct::where(['branch_id' => requestOrUserBranch($request->branch_id), 'product_id' => $request->product_id])->first();
            $branchproduct->total_qty = ($branchproduct->total_qty + $request->qty);
            $branchproduct->available_qty = ($branchproduct->available_qty - $request->qty);
            $branchproduct->used_qty =($branchproduct->used_qty + $request->qty);
            $branchproduct->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();
        return redirect()->back()->with('success', 'Use product successfully Saved');

    }

    public function getAvailableQty(Request $request)
    {

        $branch_id = $request->branch_id;
        $product_id = $request->product_id;


        $dataQty = BranchProduct::where(['branch_id' => $branch_id, 'product_id' => $product_id])->first();
        if ($dataQty) {
            return $dataQty->available_qty;
        } else {
            return 0;
        }

    }

    public function availableProductList()
    {
        $common_data = new Array_();
        $common_data->title = 'Available Product List';
        $common_data->page_title = 'Available Product List';
        $branches = Branch::where('deleted', 0)->get();
        return view('ProductInventory::available_product_list')->with(compact('branches', 'common_data'));
    }

    public function getAvailableProductList(Request $request)
    {
        $branch_id = $request->branch_id;
        $products = BranchProduct::where('branch_id', $branch_id)->get();

        return view('ProductInventory::_available_product_list')->with(compact('products'))->render();

    }
}
