<?php

namespace App\Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\Invoice\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class SaleReportController extends Controller
{
    public function index(Request $request)
    {
        $common_data = new Array_();
        $common_data->title = 'Sale Report';
        $common_data->page_title = 'Sale Report';


        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
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

        $invdetails = Invoice::when(!userInBranch(), function ($q) use ($request) {
            $q->where('branch_id', $request->branch_id);
        })->when(userInBranch(), function ($q) use ($request) {
            $q->where('branch_id', myBranchOrNull());
        })
            ->where('deleted', 0)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        $branches = Branch::where('deleted', 0)->get();

        return view("Report::saleReport.index")->with(compact('invdetails', 'common_data', 'branches'));

    }

}
