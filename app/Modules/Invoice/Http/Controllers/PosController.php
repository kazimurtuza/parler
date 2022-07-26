<?php

namespace App\Modules\Invoice\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\BranchProduct;
use App\Modules\Accounts\Models\TransactionHistory;
use App\Modules\BankAccount\Models\BankAccount;
use App\Modules\Branch\Models\Branch;
use App\Modules\BranchService\Models\BranchService;
use App\Modules\Customer\Models\Customer;
use App\Modules\CustomerMembership\Models\CustomerMembership;
use App\Modules\CustomerWallet\Models\CustomerWallet;
use App\Modules\Employee\Models\Employee;
use App\Modules\Invoice\Models\Invoice;
use App\Modules\InvoiceDetails\Models\InvoiceDetails;
use App\Modules\VatTaxSetting\Models\VatTaxSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class PosController extends Controller
{

    public function pos(){
        $common_data = new Array_();
        $common_data->title = 'Invoice Create';
        $common_data->page_title = 'Invoice Create';
        $common_data->sidebar_menu = 'hide';


        $customers=Customer::where(['deleted'=>0,'status'=>1])->orderBy('id', 'ASC')->get();
        $branches=Branch::where('deleted',0)->where('status',1)->get();
        $memberships=CustomerMembership::where('deleted',0)->where('status',1)->get();
        $blood_groups=CommonHelper::getBloodGroups();
        $paymentTypes=CommonHelper::getPaymentType();
        $vatTax=VatTaxSetting::where('deleted',0)->where('status',1)->get();
        return view('Invoice::pos')->with(compact(
            'customers',
            'common_data',
            'branches',
            'paymentTypes',
            'memberships',
            'blood_groups',
            'vatTax'
        ));
    }
    public function posBranchProduct(Request $request){

        $branch_id= $request->branch_id;
        $services=BranchService::where(['branch_id'=>$branch_id])->get();
        $employees=Employee::where('type', 'staff')->where(['branch_id'=>$branch_id,'deleted'=>0,'status'=>1])->get();
        $banklists=BankAccount::where(['branch_id'=>$branch_id,'deleted'=>0,'status'=>1])->get();
        $employee_list =view('Invoice::ajax_pos._pos_employee_list')->with(compact('employees'))->render();
        $service_list= view('Invoice::ajax_pos._pos_product_list')->with(compact('services'))->render();
        $banklistsdata= view('Invoice::ajax_pos._pos_bank_list')->with(compact('banklists'))->render();


        return [$employee_list,$service_list,$banklistsdata];
    }

    public function posProductSrc(Request $request){
       $product_name= $request->product_name;

       $services = BranchService::with('service')
           ->where('branch_id',$request->branch_id)
           ->whereHas('service', function ($q) use ($product_name) {
               $q->where('services.name', 'LIKE','%'.$product_name.'%');
           })
//           ->where('service.name','LIKE','%'.$product_name.'%')
           ->get();

       return view('Invoice::ajax_pos._pos_product_list')->with(compact('services'))->render();

    }
    public function store(Request $request){


        DB::beginTransaction();
        try {
            $invoiceData = new Invoice();
            $invoiceData->customer_id = $request->customer_id;
            $invoiceData->branch_id = requestOrUserBranch($request->branch_id);
            $invoiceData->discount_type = $request->customer_discount_type;
            $invoiceData->discount_value = $request->customer_discount_val;
            $invoiceData->status = 1;
            $invoiceData->created_at = Carbon::now();
            $invoiceData->created_by = Auth::id();
            $invoiceData->save();


            $inv_total_amount = 0; /*not used*/
            $inv_total_payable = 0;
            $inv_total_discount = 0; /*not used*/
            $customer_discount = 0;

            foreach ($request->service_id as $key => $service_id) {
                $total_price = $request->unit_price[$key] * $request->quantity[$key];
                $discount_amount = 0;
                if ($request->discount_type[$key] == 1) {
                    $discount_amount = ($total_price * $request->discount[$key]) / 100;
                }
                if ($request->discount_type[$key] == 0) {
                    $discount_amount = $request->discount[$key] * $request->quantity[$key];
                }
                $payable = $total_price - $discount_amount;
                $invoiceDetails = new InvoiceDetails();
                $invoiceDetails->invoice_id =$invoiceData->id;
                $invoiceDetails->branch_id = requestOrUserBranch($request->branch_id);
                $invoiceDetails->employee_id = $request->employee_id[$key];
                $invoiceDetails->service_id = $service_id;
                $invoiceDetails->unit_price = $request->unit_price[$key];
                $invoiceDetails->quantity = $request->quantity[$key];
                $invoiceDetails->discount_type = $request->discount_type[$key];
                $invoiceDetails->discount_value = $request->discount[$key];
                $invoiceDetails->discount_amount = $discount_amount;
                $invoiceDetails->total_amount = $total_price;
                $invoiceDetails->payable_amount = $payable;
                $invoiceDetails->status = 1;
                $invoiceDetails->created_at = Carbon::now();
                $invoiceDetails->created_by = Auth::id();
                $invoiceDetails->save();

                $inv_total_amount += $total_price;
                $inv_total_payable += $payable;
                $inv_total_discount += $discount_amount;
            }

            if ($request->customer_discount_type == 1) {
                $customer_discount = ($inv_total_payable * $request->customer_discount_val) / 100;
            }
            if ($request->customer_discount_type == 0) {
                $customer_discount = $request->customer_discount_val;
            }

            $payableBalance = $inv_total_payable - $customer_discount;




            $customWalletIn = new CustomerWallet();
            $customWalletIn->customer_id = $request->customer_id;
            $customWalletIn->type = 'in';
            $customWalletIn->type_description = 'Invoice Payment';
            $customWalletIn->reference = 'invoice';
            $customWalletIn->bank_account_id = $request->bank_account_id;
            $customWalletIn->reference_id = $invoiceData->id;
            $customWalletIn->branch_id = requestOrUserBranch($request->branch_id);
            $customWalletIn->datetime = Carbon::now();
            $customWalletIn->amount = $request->amount;
            $customWalletIn->note = 'Invoice Payment';
            $customWalletIn->status = 1;
            $customWalletIn->created_at = Carbon::now();
            $customWalletIn->created_by = Auth::id();
            $customWalletIn->save();
            $customWalletIn->transaction_no = 1000 + $customWalletIn->id;
            $customWalletIn->save();

            $customWalletOut = new CustomerWallet();
            $customWalletOut->customer_id = $request->customer_id;
            $customWalletOut->type = 'out';
            $customWalletOut->type_description = 'Invoice Payment';
            $customWalletOut->reference = 'invoice';
            $customWalletOut->bank_account_id = $request->bank_account_id;
            $customWalletOut->reference_id = $invoiceData->id;
            $customWalletOut->branch_id = requestOrUserBranch($request->branch_id);
            $customWalletOut->datetime = Carbon::now();
            $customWalletOut->amount = $payableBalance;
            $customWalletOut->note = 'Invoice Payment';
            $customWalletOut->status = 1;
            $customWalletOut->created_at = Carbon::now();
            $customWalletOut->created_by = Auth::id();
            $customWalletOut->save();
            $customWalletOut->transaction_no = 1000 + $customWalletOut->id;
            $customWalletOut->save();


            $transectionHistory = new TransactionHistory;
            $transectionHistory->type = 'in';
            $transectionHistory->type_description = 'Service Sale';
            $transectionHistory->branch_id = requestOrUserBranch($request->branch_id);
            $transectionHistory->reference = "invoice";
            $transectionHistory->reference_id = $invoiceData->id;
            $transectionHistory->bank_account_id = $request->bank_account_id;
            $transectionHistory->datetime = Carbon::now();
            $transectionHistory->amount = $request->amount;
            $transectionHistory->note = 'Service Sale';
            $transectionHistory->status = 1;
            $transectionHistory->created_at = Carbon::now();
            $transectionHistory->created_by = Auth::id();
            $transectionHistory->save();
            $transectionHistory->transaction_no = 1000 + $transectionHistory->id;
            $transectionHistory->save();


            $customerWalletUpdate = Customer::find($request->customer_id);

            $invoiceData->previous_wallet_balance = $customerWalletUpdate->available_balance;

            $available_balance = $customerWalletUpdate->available_balance;
            $customerWalletUpdate->available_balance = ($available_balance + $request->amount) - $payableBalance;
            $customerWalletUpdate->save();

            $invoiceData->invoice_no = (1000 + $invoiceData->id);
            $invoiceData->total_amount = $inv_total_payable;
            $invoiceData->payable_amount = $payableBalance;
            $invoiceData->discount_amount = $customer_discount;
            $invoiceData->payment_method = $request->bank_account_id;
            $invoiceData->paid_amount = $request->amount;
            $invoiceData->new_wallet_balance = $customerWalletUpdate->available_balance;

            $invoiceData->save();


        } catch (\Exception $exception) {
            DB::rollBack();

            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();
        return redirect()->route('admin.invoice.details', $invoiceData->id)->with('success', 'Invoice successfully saved ');

    }
}
