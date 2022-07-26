<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\Expense;
use App\Modules\BankAccount\Models\BankAccount;
use App\Modules\Branch\Models\Branch;
use App\Modules\Customer\Models\Customer;
use App\Modules\Employee\Models\Employee;
use App\Modules\Invoice\Models\Invoice;
use App\Modules\ProductRequisition\Models\ProductRequisition;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpParser\Node\Expr\Array_;

class DashboardController extends Controller
{
    public function home(){

        $common_data = new Array_();
        $common_data->title = 'Dashboard';
        $common_data->page_title = 'Dashboard';


        $dashboard_data['total_customer'] = Customer::where('status', 1)->where('deleted', 0)->count();
        if (isAdmin()) {
            $dashboard_data['total_employee'] = Employee::where('status', 1)->where('deleted', 0)->count();
            $dashboard_data['total_sale'] = Invoice::where('status', 1)
                ->where('deleted', 0)
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('payable_amount');
            $dashboard_data['total_expense'] = Expense::where('status', 1)
                ->where('deleted', 0)
                ->where('datetime', '>=', Carbon::now()->startOfMonth())
                ->sum('amount');
        } else {
            $dashboard_data['total_employee'] = Employee::where('branch_id', myBranchId())
                ->where('status', 1)
                ->where('deleted', 0)
                ->count();
            $dashboard_data['total_sale'] = Invoice::where('branch_id', myBranchId())
                ->where('status', 1)
                ->where('deleted', 0)
                ->where('created_at', '>=', Carbon::now()->startOfMonth())
                ->sum('payable_amount');
            $dashboard_data['total_expense'] = Expense::where('branch_id', myBranchId())
                ->where('status', 1)
                ->where('deleted', 0)
                ->where('datetime', '>=', Carbon::now()->startOfMonth())
                ->sum('amount');
        }


       $customers= Customer::orderBy('id', 'DESC')->take(5)->get();

        $branches=Branch::where('deleted',0)->where('status',1)->get();
        $today_total_sale=Invoice::where('created_at','>=',Carbon::now()->startOfDay())->sum('payable_amount');

        $banks=BankAccount::where('deleted',0)->where('status',1)->get();

        $invoices=Invoice::orderBy('id','DESC')->take(5)->get();

        $product_requisitions =ProductRequisition::where('approve_status',0)->orderBy('id','DESC')->take(5)->get();

        $expenses=Expense::take(5)->get();



        return view('admin.index')->with(compact(
            'common_data',
            'dashboard_data',
            'customers',
            'branches',
            'banks',
            'today_total_sale',
            'invoices',
            'product_requisitions',
            'expenses'
        ));
    }
}
