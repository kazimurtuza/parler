<?php

namespace App\Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Customer\Models\Customer;
use App\Modules\CustomerMembership\Models\CustomerMembership;
use App\Modules\Invoice\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class MembershipReportController extends Controller
{
    public function index(Request $request, $id)
    {
        $common_data = new Array_();
        $common_data->title = 'Membership Report';
        $common_data->page_title = 'Membership Report';

        $selectedMembership='';
        $selectedDateRange='';
        $selectedStartDate='';
        $selectedEndDate='';

        $memberships = CustomerMembership::where(['deleted' => 0, 'status' => 1])->get();
        if ($id == 'all') {
            $membershipList = Customer::with(['invoices' => function ($q) {
                $q->withCount('details');
            }, 'customerInWallets'])->get();

        } else {
            $membership_id = $request->membership_id;
            $getDate = $this->getdate($request);
            $startDate = $getDate[0];
            $endDate = $getDate[1];
            $membershipList = Customer::with(['invoices' => function ($q) {
                $q->withCount('details');
            }, 'customerInWallets'])
                ->whereHas('membership', function ($q) use ($membership_id) {
                    $q->where('id', $membership_id);
                })
                ->whereHas('invoices', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->get();

            $selectedMembership=$request->membership_id;
            $selectedDateRange=$request->date_range;
            $selectedStartDate=$request->start_date;
            $selectedEndDate=$request->end_date;

        }
        $selectedInfo=[$selectedMembership,$selectedDateRange,$selectedStartDate,$selectedEndDate];

        return view('Report::membershipReport.index')->with(compact('memberships', 'membershipList','common_data','selectedInfo'));

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
