<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Modules\Product\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function readNotice(Request $request)
    {
        $id = $request->id;
        $notice = Notification::where('id', $id)->first();
        if (!empty($notice)) {
            $read_users = $notice->read_users;
            if (($read_users == null) || ($read_users == '')) {
                $read_users = '-'.Auth::id().'-';
            } else {
                $read_users = $read_users.Auth::id()."-";
            }

            $notice->read_users = $read_users;
            $notice->save();
        }
    }
}
