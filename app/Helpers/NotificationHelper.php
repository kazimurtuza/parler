<?php

namespace App\Helpers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationHelper
{
    public static function getUserUnreadNotice($count = 0, $skip = 0)
    {
        $auth_user = Auth::user();
        if ($count == 0) {
            $count = Notification::count() - $skip;
            $notices = Notification::with('createdBy')
                ->where('status', 1)
                ->where(function ($z) use ($auth_user) {
                    $z->where('read_users', 'NOT LIKE', "%-{$auth_user->id}-%")
                        ->orWhere('read_users', null);
                })

                ->where(function ($s) use ($auth_user) {
                    $s->where('user_type', 1)
                        ->orWhere(function ($q) use ($auth_user) {
                            $q->where('user_type', 2);
                            $q->where('user_id', $auth_user->id);
                        });
                })
                ->where('created_at', '>=', $auth_user->created_at)

                ->orderBy('id', 'DESC')
                ->skip($skip)
                ->take($count)
                ->get();
        } else {
            $notices = Notification::with('createdBy')
                ->where('user_type', 1)
                ->orWhere(function ($q) use ($auth_user) {
                    $q->where('user_type', 2);
                    $q->where('user_id', $auth_user->id);
                })
                ->where(function ($z) use ($auth_user) {
                    $z->where('read_users', 'NOT LIKE', "%-{$auth_user->id}-%")
                        ->orWhere('read_users', null);
                })
                ->where('created_at', '>=', $auth_user->created_at)
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->skip($skip)
                ->take($count)
                ->get();
        }

        return $notices;
    }

    public static function getAdminUnreadNotice($count = 0, $skip = 0)
    {
        $auth_user = Auth::user();
        if (!in_array($auth_user->role, ['admin','super_admin'])) {
            return [];
        }
        if ($count == 0) {
            $count = Notification::count() - $skip;
            $notices = Notification::with('createdBy')
                ->where('status', 1)
                ->where(function ($z) use ($auth_user) {
                    $z->where('read_users', 'NOT LIKE', "%-{$auth_user->id}-%")
                        ->orWhere('read_users', null);
                })

                ->where(function ($s) use ($auth_user) {
                    $s->where('user_type', 1)
                        ->orWhere(function ($q) use ($auth_user) {
                            $q->where('user_type', 2);
                            $q->where('user_id', $auth_user->id);
                        })
                        ->orWhere('user_type', 3);
                })
                ->where('created_at', '>=', $auth_user->created_at)

                ->orderBy('id', 'DESC')
                ->skip($skip)
                ->take($count)
                ->get();
        } else {
            $notices = Notification::with('createdBy')
                ->where(function ($s) use ($auth_user) {
                    $s->where('user_type', 1)
                        ->orWhere(function ($q) use ($auth_user) {
                            $q->where('user_type', 2);
                            $q->where('user_id', $auth_user->id);
                        })
                        ->orWhere('user_type', 3);
                })
                ->where(function ($z) use ($auth_user) {
                    $z->where('read_users', 'NOT LIKE', "%-{$auth_user->id}-%")
                        ->orWhere('read_users', null);
                })
                ->where('created_at', '>=', $auth_user->created_at)
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->skip($skip)
                ->take($count)
                ->get();
        }

        return $notices;
    }
}
