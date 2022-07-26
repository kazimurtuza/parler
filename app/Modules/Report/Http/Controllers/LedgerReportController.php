<?php

namespace App\Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Accounts\Models\TransactionHistory;
use App\Modules\Branch\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class LedgerReportController extends Controller
{
    public function index(Request $request, $id)
    {

        $common_data = new Array_();
        $common_data->title = 'Ledger Report';
        $common_data->page_title = 'Ledger Report';
        $branches= Branch::where(['deleted' => 0, 'status' => 1])->get();


        if ($request->date_range) {
            $ledgers = TransactionHistory::where(['deleted'=>0,'status'=>1])->when(myBranchOrNull(),function($q){
                $q->where('branch_id',myBranchOrNull());
            })->get();

        } else {
            $getDate = $this->getdate($request);
            $startDate = $getDate[0];
            $endDate = $getDate[1];

            $ledgers = TransactionHistory::where(['deleted'=>0,'status'=>1,'branch_id'=>requestOrUserBranch($request->branch_id)])->whereBetween('datetime', [$startDate, $endDate])->get();


        }


        return view('Report::ledgerReport.index')->with(compact('ledgers', 'branches','common_data'));

    }

    public function getdate($request)
    {

        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();

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

        return [$startDate, $endDate];
    }
}
