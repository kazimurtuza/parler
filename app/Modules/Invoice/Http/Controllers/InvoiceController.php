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
use App\Modules\Service\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use phpDocumentor\Reflection\Types\Array_;
use PDF;

class InvoiceController extends Controller
{
    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Invoice';
        $common_data->page_title = 'Invoice';

        $invdetails = Invoice::when(myBranchOrNull(),function($q){
            $q->where('branch_id',myBranchOrNull());
        })
        ->where('deleted', 0)->get();

        return view("Invoice::index")->with(compact('invdetails', 'common_data'));

    }

    public function create()
    {
        $common_data = new Array_();
        $common_data->title = 'Invoice Create';
        $common_data->page_title = 'Invoice Create';
        $branches = Branch::where('deleted', 0)->where('status', 1)->get();
        $memberships=CustomerMembership::where('deleted',0)->get();

        return view("Invoice::create")->with(compact('branches','common_data','memberships'));
    }

    public function store(Request $request)
    {
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


            $inv_total_amount = 0;
            $inv_total_payable = 0;
            $inv_total_discount = 0;
            $customer_discount=0;

            foreach ($request->service_id as $key => $service_id) {
                $total_price = $request->unit_price[$key] * $request->quantity[$key];
                if ($request->discount_type[$key] == 1) {
                    $discount_amount = ($total_price * $request->discount[$key]) / 100;
                }
                if ($request->discount_type[$key] == 0) {
                    $discount_amount = $request->discount[$key]*$request->quantity[$key];
                }
                $payable = $total_price - $discount_amount;
                $invoicedetails = new InvoiceDetails();
                $invoicedetails->invoice_id = $invoiceData->id;
                $invoicedetails->branch_id = requestOrUserBranch($request->branch_id);;
                $invoicedetails->employee_id = $request->employee_id[$key];
                $invoicedetails->service_id = $service_id;
                $invoicedetails->unit_price = $request->unit_price[$key];
                $invoicedetails->quantity = $request->quantity[$key];
                $invoicedetails->discount_type = $request->discount_type[$key];
                $invoicedetails->discount_value = $request->discount[$key];
                $invoicedetails->discount_amount = $discount_amount;
                $invoicedetails->total_amount = $total_price;
                $invoicedetails->payable_amount = $payable;
//                $invoicedetails->vat_percent = $request->vat_percent;
                $invoicedetails->status = 1;
                $invoicedetails->created_at = Carbon::now();
                $invoicedetails->created_by = Auth::id();
                $invoicedetails->save();
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

            $payableBalance=$inv_total_payable-$customer_discount;


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
        return redirect()->back()->with('success', 'Invoice successfully saved ');
    }

    public function edit($id){
        $common_data = new Array_();
        $common_data->title = 'Invoice Edit';
        $common_data->page_title = 'Invoice  Edit';

        $invoicedata=Invoice::find($id);
        $branches = Branch::where('deleted', 0)->where('status', 1)->where('id',$invoicedata->branch_id)->get();
        $customers=Customer::where('deleted', 0)->orderBy('id', 'ASC')->get();
        $employees=Employee::where('deleted', 0)->where('status', 1)->where('type','staff')->where('branch_id',$invoicedata->branch_id)->get();
        $services=BranchService::where('deleted', 0)->where('status', 1)->where('branch_id',$invoicedata->branch_id)->get();
        $bankAccounts=BankAccount::where('branch_id',$invoicedata->branch_id)->where('deleted',0)->get();
        return view("Invoice::edit")->with(compact(
            'invoicedata',
            'branches',
            'customers',
            'employees',
            'services',
            'common_data',
            'bankAccounts'
        ));
    }
    public function update(Request $request){
        DB::beginTransaction();
        try {
            $invoiceData = Invoice::find($request->invoice_id);
            $invoiceData->customer_id = $request->customer_id;
            $invoiceData->discount_type = $request->customer_discount_type;
            $invoiceData->discount_value = $request->customer_discount_val;
            $invoiceData->status = 1;
            $invoiceData->updated_at = Carbon::now();
            $invoiceData->updated_by = Auth::id();
            $invoiceData->save();


            $inv_total_amount = 0;
            $inv_total_payable = 0;
            $inv_total_discount = 0;
            $customer_discount=0;

            InvoiceDetails::whereNotIn('id',$request->invoice_detail_id)
                ->where('invoice_id',$request->invoice_id)
                ->delete();

            foreach ($request->service_id as $key => $service) {
                $total_price = $request->unit_price[$key] * $request->quantity[$key];
                if ($request->discount_type[$key] == 1) {
                    $discount_amount = ($total_price * $request->discount[$key]) / 100;
                }
                if ($request->discount_type[$key] == 0) {
                    $discount_amount = $request->discount[$key]*$request->quantity[$key];
                }
                $payable = $total_price - $discount_amount;
                if(isset($request->invoice_detail_id[$key])){
                    $invoicedetails = InvoiceDetails::find($request->invoice_detail_id[$key]);
                    $invoicedetails->updated_at = Carbon::now();
                    $invoicedetails->updated_by = Auth::id();
                }else{
                    $invoicedetails = new InvoiceDetails();
                    $invoicedetails->status = 1;
                    $invoicedetails->created_at = Carbon::now();
                    $invoicedetails->created_by = Auth::id();
                    $invoicedetails->invoice_id = $invoiceData->id;
                    $invoicedetails->branch_id = $invoiceData->branch_id;
                }


                $invoicedetails->employee_id = $request->employee_id[$key];
                $invoicedetails->service_id = $request->service_id[$key];
                $invoicedetails->unit_price = $request->unit_price[$key];
                $invoicedetails->quantity = $request->quantity[$key];
                $invoicedetails->discount_type = $request->discount_type[$key];
                $invoicedetails->discount_value = $request->discount[$key];
                $invoicedetails->discount_amount = $discount_amount;
                $invoicedetails->total_amount = $total_price;
                $invoicedetails->payable_amount = $payable;
                $invoicedetails->save();
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





//            edit account part
            $customerInGet= CustomerWallet::where(['type'=>'in','reference_id'=>$invoiceData->id])->first();
            $customWalletIn = $customerInGet;
            $customWalletIn->customer_id = $request->customer_id;
            $customWalletIn->type = 'in';
            $customWalletIn->bank_account_id = $request->bank_account_id;
            $customWalletIn->amount = $request->amount;
            $customWalletIn->updated_at = Carbon::now();
            $customWalletIn->updated_by = Auth::id();
            $customWalletIn->save();


            $customerOutGet= CustomerWallet::where(['type'=>'out','reference_id'=>$invoiceData->id])->first();
            $customWalletOut = $customerOutGet;
            $customWalletOut->customer_id = $request->customer_id;
            $customWalletOut->type = 'out';
            $customWalletOut->bank_account_id = $request->bank_account_id;
            $customWalletOut->amount = $payable;
            $customWalletOut->updated_at = Carbon::now();
            $customWalletOut->updated_by = Auth::id();
            $customWalletOut->save();

//  ;
            $transerctionGet=TransactionHistory::where(['type'=>'in','reference_id'=>$invoiceData->id])->first();
            $transectionHistory = $transerctionGet;
            $transectionHistory->type = 'in';
            $transectionHistory->bank_account_id = $request->bank_account_id;
            $transectionHistory->branch_id = requestOrUserBranch($request->branch_id);
            $transectionHistory->datetime = Carbon::now();
            $transectionHistory->amount = $request->amount;
            $transectionHistory->updated_at = Carbon::now();
            $transectionHistory->updated_by = Auth::id();
            $transectionHistory->save();


            $customerWalletUpdate = Customer::find($request->customer_id);

            $invoiceData->previous_wallet_balance = $customerWalletUpdate->available_balance;

            $available_balance = $customerWalletUpdate->available_balance;
            $customerWalletUpdate->available_balance = ($available_balance + $request->amount) - $payable;
            $customerWalletUpdate->save();


            $invoiceData->invoice_no = (1000 + $invoiceData->id);
            $invoiceData->total_amount = $inv_total_payable;
            $invoiceData->payable_amount = $inv_total_payable-$customer_discount;
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
        return redirect()->back()->with('success', 'Invoice successfully updated ');
    }

    public function invBranchData(Request $request)
    {

        $customers = Customer::where('deleted', 0)->where('status', 1)->orderBy('id', 'ASC')->get();
        $services = BranchService::where('deleted', 0)->where('status', 1)->where('branch_id', $request->branch_id)->get();
        $employees = Employee::where('deleted', 0)->where('status', 1)->where('type','staff')->where('branch_id', $request->branch_id)->get();
        $banklists=BankAccount::where('deleted', 0)->where('status', 1)->where('branch_id', $request->branch_id)->get();
        $customer_view = view('Invoice::ajax._branch_customers')
            ->with(compact('customers'))
            ->render();
        $service_view = view('Invoice::ajax._branch_services')
            ->with(compact('services'))
            ->render();
        $employee_view = view('Invoice::ajax._branch_employees')
            ->with(compact('employees'))
            ->render();
        $bank_view = view('Invoice::ajax_pos._pos_bank_list')
            ->with(compact('banklists'))
            ->render();

        return response()->json([
            'customer_view' => $customer_view,
            'service_view' => $service_view,
            'employee_view' => $employee_view,
            'bank_view' => $bank_view,
        ]);

    }

    public function details($id){
        $common_data = new Array_();
        $common_data->title = 'Invoice Details';
        $common_data->page_title = 'Invoice  Details';

        $invoicedata=Invoice::find($id);
        $branches = Branch::where('deleted', 0)->where('status', 1)->where('id',$invoicedata->branch_id)->get();
        $customers=Customer::where('deleted', 0)->orderBy('id', 'ASC')->get();
        $employees=Employee::where('deleted', 0)->where('status', 1)->where('type','staff')->where('branch_id',$invoicedata->branch_id)->get();
        $services=BranchService::where('deleted', 0)->where('status', 1)->where('branch_id',$invoicedata->branch_id)->get();

        return view("Invoice::details")->with(compact(
            'invoicedata',
            'branches',
            'customers',
            'employees',
            'services',
            'common_data'
        ));

    }

    public function printPDF(Request $request, $id){
        $common_data = new Array_();
        $common_data->title = 'Invoice Details';
        $common_data->page_title = 'Invoice  Details';

        $invoice = Invoice::find($id);
        $branches = Branch::where('deleted', 0)->where('status', 1)->where('id', $invoice->branch_id)->get();
        $customers = Customer::where('deleted', 0)->orderBy('id', 'ASC')->get();
        $employees = Employee::where('deleted', 0)->where('status', 1)->where('type', 'staff')->where('branch_id', $invoice->branch_id)->get();
        $services = BranchService::where('deleted', 0)->where('status', 1)->where('branch_id', $invoice->branch_id)->get();
        /*return view('Invoice::pdf.pdf', compact(
            'invoice',
            'branches',
            'customers',
            'employees',
            'services',
            'common_data'
        ));*/
        $pdf = PDF::loadView('Invoice::pdf.pdf', compact(
            'invoice',
            'branches',
            'customers',
            'employees',
            'services',
            'common_data'
        ));
//        $pdf->setPaper('a4');
        $pdf->setOption('page-height', '210');
        $pdf->setOption('page-width', '148.5');
//        $pdf->setOrientation('portrait');
//        $pdf->setOption('header-html', );
        $footer_text = CommonHelper::getInvoiceFooterText('');
        $header_html = View::make('Invoice::pdf._pdf_header')->render();
//        $pdf->setOption('header-html', $header_html);
        $pdf->setOption('footer-html', $footer_text);
        $pdf->setOption('margin-top',0);
        $pdf->setOption('margin-left',3.5);
        $pdf->setOption('margin-right',7);
        $pdf->setOption('margin-bottom',10);
        if ($request->download == 'pdf') {
            return $pdf->download('INV-'.$invoice->invoice_no.'_'.$invoice->customer->full_name.'.pdf');
        }
        return $pdf->inline();


    }




}
