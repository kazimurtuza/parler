<?php

namespace App\Modules\ProductRequisitionDetails\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductRequisitionDetailsController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("ProductRequisitionDetails::welcome");
    }
}
