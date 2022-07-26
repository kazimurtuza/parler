<?php

namespace App\Modules\Product\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Modules\Product\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\Array_;


class ProductController extends Controller
{
    public function index()
    {
        $common_data = new Array_();
        $common_data->title = 'Product';
        $common_data->page_title = 'Product';
        $products=Product::where('deleted', 0)->get();

        return view("Product::index")
            ->with(compact(
                'common_data',
                'products'
            ));
    }

    public function store(Request $request)
    {
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


        return redirect()->back()->with(['success' => 'Product Added Success']);
    }

    public function edit($id)
    {
        $product=Product::find($id);


        if (empty($product)) {
            return response()->json([
                'status' => 400,
                'msg' => 'Invalid Product'
            ]);
        }

        $view = view("Product::_edit_product_data")->with(compact('product'))->render();
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
                'name'=> 'required',
                'image'=> 'nullable',
                'price'=> 'required',
                'note'=> 'nullable',

            ]);
            $product=Product::find($id);

            if ($request->hasFile('image')) {
                $name = "product_".time().rand(1000,9999). "." . $request->file('image')->extension();
                $icon_url = CommonHelper::uploadFile($request->file('image'), $name, 'product');
                $validator['image'] = $icon_url;
            }else{
                $validator['image'] = $product->image;
            }
            $validator['updated_at'] = Carbon::now();
            $validator['updated_by'] = Auth::id();
            $product->update($validator);

        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }
        return redirect()->back()->with(['success' => 'Product Update Successs']);
    }
//
    public function updateStatus($id, $status)
    {
        try {
            $product = Product::where('id', $id)
                ->first();
            if (empty($product)) {
                return response()->json([
                    'status' => 400,
                    'msg' => 'Invalid Product'
                ]);
            }

            $product->status = $status;
            $product->save();
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
        $user = Product::find($id);
        $user->status = 0;
        $user->deleted_at=Carbon::now();
        $user->deleted_by = Auth::id();
        $user->deleted = 1;
        $user->save();


        return redirect()->back()->with(['success' => 'Product  Deleted Successfully']);
    }

    public function bulkDelete(Request $request)
    {
       $product= Product::whereIn('id',$request->ids)->update([
            'status' => 0,
            'deleted_at' => Carbon::now(),
            'deleted_by' => Auth::id(),
            'deleted' => 1
        ]);

       if($product){
           return '200';
       }else{
           return '400';
       }
   }
   public function productImport(Request $request){

       Excel::import(new ProductsImport, $request->file('import_file'));
       return redirect()->back()->with(['success' => 'Product Import Success.']);

  }
}
