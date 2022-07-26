<?php

namespace App\Modules\Customer\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\Customer\Models\Customer;
use App\Modules\CustomerMembership\Models\CustomerMembership;
use App\Modules\CustomerWallet\Models\CustomerWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class CustomerController extends Controller
{


    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Customer';
        $common_data->page_title = 'Customer';
        $customers = Customer::where('deleted', 0)
            ->orderBy('id', 'ASC')
            ->get();

        $branchs = Branch::where('deleted', 0)->where('status', 1)->get();
        $memberships = CustomerMembership::where('deleted', 0)->where('status', 1)->get();
        $blood_groups = CommonHelper::getBloodGroups();


        return view("Customer::index")
            ->with(compact(
                'common_data',
                'customers',
                'branchs',
                'memberships',
                'blood_groups'
            ));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([

            'branch_id' => 'nullable',
            'customer_membership_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'available_balance' => 'required',
            'phone' => 'required',
            'email' => 'nullable',
            'address' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            $customer = new Customer();
//          $customer->branch_id=$request->branch_id;
            $customer->customer_membership_id = $request->customer_membership_id;
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            if ($request->hasFile('photo')) {
                $name = "customer_" . time() . rand(1000, 9999) . "." . $request->file('photo')->extension();
                $image_url = CommonHelper::uploadFile($request->file('photo'), $name, 'customers');
                $customer->photo = $image_url;
            }
            $customer->dob = $request->dob;
            $customer->gender = $request->gender;
            $customer->blood = $request->blood;
            $customer->available_balance = $request->available_balance;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->created_at = Carbon::now();
            $customer->created_by = Auth::id();
            $customer->save();

            if ($request->available_balance != 0) {
                $customerWallet = new CustomerWallet;
                $customerWallet->customer_id = $customer->id;
                $customerWallet->type = 'in';
                $customerWallet->type_description = 'previous wallet amount';
                $customerWallet->datetime = Carbon::now();
                $customerWallet->amount = $request->available_balance;
                $customerWallet->status = 1;
                $customerWallet->created_at = Carbon::now();
                $customerWallet->created_by = Auth::id();
                $customerWallet->save();
                $customerWallet->transaction_no = 1000 + $customerWallet->id;
                $customerWallet->save();

            }

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();


        return redirect()->back()->with(['success' => 'Customer Added Success']);
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        $branchs = Branch::where('status', 1)->where('status', 1)->get();
        $memberships = CustomerMembership::where('status', 1)->where('status', 1)->get();

        $blood_groups = CommonHelper::getBloodGroups();

        if (empty($customer)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Customer'
            ]);
        }

        $view = view("Customer::_edit_customer_data")->with(compact('customer', 'branchs', 'memberships', 'blood_groups'))->render();
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
                'branch_id' => 'nullable',
                'customer_membership_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'nullable',
                'address' => 'nullable',
                'photo' => 'nullable',
                'dob' => 'nullable',
                'gender' => 'nullable',
                'blood' => 'nullable',
            ]);

            $customer = Customer::find($id);
            if ($request->hasFile('photo')) {
                $name = "customer_" . time() . rand(1000, 9999) . "." . $request->file('photo')->extension();
                $image_url = CommonHelper::uploadFile($request->file('photo'), $name, 'customers');
                $validator['photo'] = $image_url;
            }
            $customer->update($validator);

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        return redirect()->back()->with(['success' => 'Customer Update Success']);
    }

//
    public function updateStatus($id, $status)
    {
        try {
            $membership = Customer::where('id', $id)
                ->first();
            if (empty($membership)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Membership'
                ]);
            }

            $membership->status = $status;
            $membership->updated_at = Carbon::now();
            $membership->updated_by = Auth::id();
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
        $user = Customer::find($id);
        $user->status = 0;
        $user->deleted_at = Carbon::now();
        $user->deleted_by = Auth::id();
        $user->deleted = 1;
        $user->save();

        return redirect()->back()->with(['success' => 'Customer  Deleted Successfully']);
    }

    public function bulkDelete(Request $request){
        $customer= Customer::whereIn('id',$request->ids)->update([
            'status' => 0,
            'deleted_at' => Carbon::now(),
            'deleted_by' => Auth::id(),
            'deleted' => 1
        ]);
       if($customer){
           return '200';
       }else{
           return '400';
       }



    }



    public function customerAjaxStore(Request $request)
    {

        $validator = $request->validate([

            'branch_id' => 'nullable',
            'customer_membership_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'available_balance' => 'required',
            'phone' => 'required',
            'email' => 'nullable',
            'address' => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            $customer = new Customer();
//          $customer->branch_id=$request->branch_id;
            $customer->customer_membership_id = $request->customer_membership_id;
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            if ($request->hasFile('photo')) {
                $name = "customer_" . time() . rand(1000, 9999) . "." . $request->file('photo')->extension();
                $image_url = CommonHelper::uploadFile($request->file('photo'), $name, 'customers');
                $customer->photo = $image_url;
            }
            $customer->dob = $request->dob;
            $customer->gender = $request->gender;
            $customer->blood = $request->blood;
            $customer->available_balance = $request->available_balance;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->created_at = Carbon::now();
            $customer->created_by = Auth::id();
            $customer->save();

            if ($request->available_balance != 0) {
                $customerWallet = new CustomerWallet;
                $customerWallet->customer_id = $customer->id;
                $customerWallet->type = 'in';
                $customerWallet->type_description = 'previous wallet amount';
                $customerWallet->datetime = Carbon::now();
                $customerWallet->amount = $request->available_balance;
                $customerWallet->status = 1;
                $customerWallet->created_at = Carbon::now();
                $customerWallet->created_by = Auth::id();
                $customerWallet->save();
                $customerWallet->transaction_no = 1000 + $customerWallet->id;
                $customerWallet->save();

            }

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();
        $customers = Customer::where(['deleted' => 0])->get();
        $customer_id = $customer->id;

        return view('Customer::_customer_list')->with(compact('customers', 'customer_id'))->render();

    }
}
