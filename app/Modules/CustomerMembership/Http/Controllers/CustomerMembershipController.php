<?php

namespace App\Modules\CustomerMembership\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Modules\CustomerMembership\Models\CustomerMembership;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

class CustomerMembershipController extends Controller
{


    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Membership';
        $common_data->page_title = 'Membership';
        $memberships=CustomerMembership::where('deleted', 0)->get();

        return view("CustomerMembership::index")
            ->with(compact(
                'memberships',
                'common_data'
            ));
    }

    public function store(Request $request)
    {

        $validator = $request->validate([
            'title' => 'required',
            'discount_type' => 'required',
            'discount_value' => 'required',
            'icon' => 'nullable',
        ]);


        $membership=new CustomerMembership();
        $membership->title=$request->title;
        $membership->discount_type=$request->discount_type;
        $membership->discount_value=$request->discount_value;

        /*upload pdf*/
        if ($request->hasFile('icon')) {
            $name = "icon_".time().rand(1000,9999). "." . $request->file('icon')->extension();
            $icon_url = CommonHelper::uploadFile($request->file('icon'), $name, 'membership-icon');
            $membership->icon = $icon_url;
        }
        /*upload pdf end*/
        $membership->created_at = Carbon::now();
        $membership->created_by = Auth::id();
        $membership->save();


        return redirect()->back()->with(['success' => 'Membership Added Success']);
    }

    public function edit($id)
    {
        $membership = CustomerMembership::where('id', $id)
            ->first();
        if (empty($membership)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Branch'
            ]);
        }

        $view = view("CustomerMembership::_edit_membership_data")->with(compact('membership'))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);
    }
//
    public function update(Request $request, $id)
    {

        try {
            $validator = $request->validate([
                'title' => 'required',
                'discount_type' => 'required',
                'discount_value' => 'required',
                'icon' => 'nullable',
            ]);

            $membership = CustomerMembership::where('id', $id)
                ->first();
            $membership->title=$request->title;
            $membership->discount_type=$request->discount_type;
            $membership->discount_value=$request->discount_value;

            /*upload pdf*/
            if ($request->hasFile('icon')) {

                $name = "icon_".time().rand(1000,9999). "." . $request->file('icon')->extension();
                $icon_url = CommonHelper::uploadFile($request->file('icon'), $name, 'membership');
                $membership->icon = $icon_url;
            }
            $membership->updated_at = Carbon::now();
            $membership->updated_by = Auth::id();
            $membership->save();

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        return redirect()->back()->with(['success' => 'Membership Update Successs']);
    }
//
    public function updateStatus($id, $status)
    {
        try {
            $membership = CustomerMembership::where('id', $id)
                ->first();
            if (empty($membership)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Membership'
                ]);
            }

            $membership->status = $status;
            $membership->save();
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

    public function delete($id)
    {

        $user = CustomerMembership::find($id);
        $user->status = 0;
        $user->deleted_at=Carbon::now();
        $user->deleted_by = Auth::id();
        $user->deleted = 1;
        $user->save();


        return redirect()->back()->with(['success' => 'Customer Membership Deleted Successfully']);
    }

}
