<?php

namespace App\Modules\ProductRequisition\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Modules\BankAccount\Models\BankAccount;
use App\Modules\Branch\Models\Branch;
use App\Modules\Product\Models\Product;
use App\Modules\ProductInventory\Models\ProductInventory;
use App\Modules\ProductRequisition\Models\ProductRequisition;
use App\Modules\ProductRequisitionDetails\Models\ProductRequisitionDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class ProductRequisitionController extends Controller
{

    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Product Requisition';
        $common_data->page_title = 'Product Requisition';
        $product_requisitions=ProductRequisition::where('deleted', 0)->get();


        return view("ProductRequisition::index")
            ->with(compact(
                'common_data',
                'product_requisitions'

            ));
    }

    public function add(){
        $common_data = new Array_();
        $common_data->title = 'Product Requisition';
        $common_data->page_title = 'New Requisition';
        $branches=Branch::where('deleted', 0)->get();
        $products=Product::where('deleted',0)->get();

        return view("ProductRequisition::create")->with(compact(
            'common_data',
            'products',
            'branches'
        ));

    }

    public function productRequisitionList(){
        $products=Product::where('deleted',0)->get();

        $view = view("ProductRequisition::_productrequisitionlist")->with(compact('products'))->render();
        return response()->json([
            'status' => 200,
            'view' => $view
        ]);

    }

    public function store(Request $request){

        $request->validate([
            'product_id'=>'required',
            'price'=>'required',
            'quantity'=>'required',
        ]);
        if(isAdmin()){
            $request->validate([
            'branch_id'=>'required',
                ]);
        }


        DB::beginTransaction();
        try {

            $total_amount = 0;

            $productRequisition = new ProductRequisition();
            $productRequisition->branch_id = requestOrUserBranch($request->branch_id);
            $productRequisition->total_amount = $total_amount;
            $productRequisition->requested_by = Auth::user()->id;
            $productRequisition->approve_status = 0;

            $productRequisition->created_at = Carbon::now();
            $productRequisition->created_by = Auth::id();

            $productRequisition->save();

            foreach ($request->product_id as $key=>$productinfo) {
                $inner_total = $request->price[$key] * $request->quantity[$key];
                $total_amount += $inner_total;

                $requisitionDetails = new ProductRequisitionDetails();
                $requisitionDetails->product_requisition_id = $productRequisition->id;
                $requisitionDetails->product_id = $request->product_id[$key];
                $requisitionDetails->unit_price = $request->price[$key];
                $requisitionDetails->quantity = $request->quantity[$key];
                $requisitionDetails->status = 0;
                $requisitionDetails->total_amount = $inner_total;
                $requisitionDetails->save();
            }


            $productRequisition->total_amount = $total_amount;
            $productRequisition->requisition_no = $productRequisition->id + 1000;
            $productRequisition->save();

            $notice_title = "";
            $notice_title = $notice_title."<a href='".route('admin.productrequisition.details', $productRequisition->id)."'>";
            $notice_title = $notice_title.$productRequisition->branch->name . " - ";
            $notice_title = $notice_title."Pending Requisition (".CommonHelper::getCurrency()['symbol'].$productRequisition->total_amount.")";
            $notice_title = $notice_title."</a>";
            $notice = new Notification();
            $notice->user_type = 3;
            $notice->user_id = 0;
            $notice->title = $notice_title;
            $notice->details = null;
            $notice->read_users = null;
            $notice->status = 1;
            $notice->created_at = Carbon::now();
            $notice->created_by = Auth::id();
            $notice->deleted = 0;
            $notice->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }

        DB::commit();
        return redirect()->back()->with(['success' => 'Product Requisition Add Successfully']);

    }

    public function productRequisitionEdit($id){
        $common_data = new Array_();
        $common_data->title = 'Requisition Edit';
        $common_data->page_title = 'Requisition Edit';

        $requisition= ProductRequisition::with('details')->find($id);
        $branches=Branch::where('deleted',0)->get();
        $products=Product::where('deleted',0)->get();

        return view('ProductRequisition::edit')->with(compact('common_data','requisition','branches','products'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'product_id'=>'required',
            'price'=>'required',
            'quantity'=>'required',
        ]);

        if(isAdmin()){
            $request->validate([
                'branch_id'=>'required',
            ]);
        }

        DB::beginTransaction();
        try {

            $total_amount=0;

            $productRequisition= ProductRequisition::find($id);

            $productRequisition->branch_id = requestOrUserBranch($request->branch_id);
            $productRequisition->total_amount = $total_amount;
            $productRequisition->requested_by = Auth::user()->id;
            $productRequisition->approve_status = 0;

            $productRequisition->updated_at = Carbon::now();
            $productRequisition->updated_by = Auth::id();
            $productRequisition->save();

            if (isset($request->detail_id) && is_array($request->detail_id)) {
                ProductRequisitionDetails::where('product_requisition_id', $productRequisition->id)
                    ->whereNotIn('id', $request->detail_id)
                    ->delete();
            } else {
                ProductRequisitionDetails::where('product_requisition_id', $productRequisition->id)
                    ->delete();
            }
            foreach ($request->product_id as $key => $productinfo) {
                if (isset($request->detail_id[$key])) {
                    $requisitionDetails = ProductRequisitionDetails::find($request->detail_id[$key]);
                } else {
                    $requisitionDetails = new ProductRequisitionDetails();
                    $requisitionDetails->product_requisition_id = $productRequisition->id;
                }
                $inner_total = $request->price[$key] * $request->quantity[$key];
                $total_amount += $inner_total;

                $requisitionDetails->product_id = $request->product_id[$key];
                $requisitionDetails->unit_price = $request->price[$key];
                $requisitionDetails->quantity = $request->quantity[$key];
                $requisitionDetails->status = 0;
                $requisitionDetails->total_amount = $inner_total;
                $requisitionDetails->save();
            }

            $productRequisition->total_amount = $total_amount;
            $productRequisition->save();

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        DB::commit();

        return redirect()->back()->with(['success' => ' Requisition  Successfully Updated']);
    }


    public function details($id){
        $common_data = new Array_();
        $common_data->title = ' Requisition Details';
        $common_data->page_title = ' Requisition Details';

        $requisition= ProductRequisition::with('details')->find($id);
        $branches=Branch::where('deleted',0)->get();
        $products=Product::where('deleted',0)->get();
        $banks = BankAccount::where('branch_id',$requisition->branch_id)
            ->where('status', 1)
            ->where('deleted', 0)
            ->get();

        return view('ProductRequisition::details')->with(compact('common_data',
            'requisition',
            'branches',
            'products',
            'banks'
        ));

    }
    public function status($id,$status){
        $requisition= ProductRequisition::find($id);
        $requisition->approve_status=$status;
        $requisition->save();

        return redirect()->back()->with(['success' => ' Requisition Status Successfully Updated']);
    }

    public function requisitionType($status){
        $common_data = new Array_();
        if($status==0){
            $common_data->title = 'Pending Requisition';
            $common_data->page_title = 'Pending Requisition';
        }elseif ($status==1){
            $common_data->title = 'Approved Requisition';
            $common_data->page_title = 'Approved Requisition';
        }elseif ($status==2){
            $common_data->title = 'Rejected Requisition';
            $common_data->page_title = 'Rejected Requisition';
        }elseif ($status==3){
            $common_data->title = 'Purchased List';
            $common_data->page_title = 'Purchased List';
        }

        $product_requisitions=ProductRequisition::when(myBranchOrNull(),function($q){
            $q->where('branch_id',myBranchOrNull());
        })
        ->where('approve_status',$status)->where('deleted', 0)->get();

        $banks = BankAccount::when(myBranchOrNull(),function($q){
            $q->where('branch_id',myBranchOrNull());
        })
            ->where('status', 1)
            ->where('deleted', 0)
            ->get();

        return view("ProductRequisition::product_requisition_list")
            ->with(compact(
                'common_data',
                'product_requisitions',
                'status',
                'banks'

            ));

    }
    public function productadd(Request $request){
        $validator = $request->validate([
            'name'=> 'required',
            'image'=> 'nullable',
            'price'=> 'required',
            'note'=> 'nullable',

        ]);

        $product=new Product();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->note=$request->note;
        if ($request->hasFile('image')) {
            $name = "product_".time().rand(1000,9999). "." . $request->file('image')->extension();
            $icon_url = CommonHelper::uploadFile($request->file('image'), $name, 'product');
            $product->image = $icon_url;
        }
        $product->created_at=Carbon::now();
        $product->created_by = Auth::id();
        $product->save();


        $productlist=Product::where('deleted',0)->get();

        return $productlist;
    }

}
