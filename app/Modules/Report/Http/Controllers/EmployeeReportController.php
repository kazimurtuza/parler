<?php

namespace App\Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\InvoiceDetails\Models\InvoiceDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class EmployeeReportController extends Controller
{
    public function index(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Employee Report';
        $common_data->page_title = 'Employee Report';


        $startDate = Carbon::now()->firstOfMonth()->startOfDay();
        $endDate = Carbon::now()->lastOfMonth()->endOfDay();
        if ($request->date_range == 'Date Range') {
            $startDate = Carbon::make($request->start_date)->startOfDay();
            $endDate = Carbon::make($request->end_date)->endOfDay();

        } elseif ($request->date_range == 'This Week') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();

        } elseif ($request->date_range == 'Last Week') {
            $startDate = \Carbon\Carbon::now()->subWeek()->startOfDay();
            $endDate = \Carbon\Carbon::now()->endOfDay();

        } elseif ($request->date_range == 'This Month') {
            $startDate = \Carbon\Carbon::now()->firstOfMonth()->startOfDay();
            $endDate = \Carbon\Carbon::now()->lastOfMonth()->endOfDay();

        } elseif ($request->date_range == 'Last Month') {
            $startDate = new Carbon('first day of last month');
            $endDate = new Carbon('last day of last month');

        } elseif ($request->date_range == 'This Year') {
            $startDate = Carbon::now()->firstOfYear()->startOfDay();
            $endDate = Carbon::now()->lastOfYear()->endOfDay();
        } elseif ($request->date_range == 'Last Year') {
            $startDate = new Carbon('first day of last year');
            $endDate = new Carbon('last day of last year');

        }



        $employeesInfo = InvoiceDetails::with('employee')->where('status', 1)
            ->when(!userInBranch(), function ($q) use ($request) {
                $q->where('branch_id', $request->branch_id);
            })->when(userInBranch(), function ($q) use ($request) {
                $q->where('branch_id', myBranchOrNull());
            })
            ->select('invoice_details.employee_id', DB::raw('count(*) as total_sale'), DB::raw('sum(payable_amount) as total_sale_amount'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('employee_id')
            ->get();


        $branches = Branch::where('deleted', 0)->get();

        return view("Report::employeeReport.index")->with(compact('employeesInfo', 'common_data', 'branches'));

    }

}
