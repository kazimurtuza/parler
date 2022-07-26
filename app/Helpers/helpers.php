<?php

if (!function_exists('isAdmin')) {
    function isAdmin() : bool {
        if ((auth()->user()->role == 'super_admin') || (auth()->user()->role == 'admin')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('myBranchId')) {
    function myBranchId() : int {
        if ((auth()->user()->role == 'super_admin') || (auth()->user()->role == 'admin')) {
            return 0;
        }
        return auth()->user()->employee->branch_id ?? 0;
    }
}

if (!function_exists('myBranchOrNull')) {
    function myBranchOrNull() {
        if ((auth()->user()->role == 'super_admin') || (auth()->user()->role == 'admin')) {
            return null;
        }
        return auth()->user()->employee->branch_id ?? 0;
    }
}

if (!function_exists('requestOrUserBranch')) {
    function requestOrUserBranch($branch_id = null) {
        if ((auth()->user()->role == 'super_admin') || (auth()->user()->role == 'admin')) {
            return $branch_id;
        }
        return auth()->user()->employee->branch_id ?? 0;
    }
}

if (!function_exists('authUserName')) {
    function authUserName() {
        return auth()->user()->full_name;
    }
}
if (!function_exists('authUserRole')) {
    function authUserRole() {
        return auth()->user()->role;
    }
}
if (!function_exists('userInBranch')) {
    function userInBranch():bool {
        $role = auth()->user()->role;
        return ($role != 'super_admin') && ($role != 'admin');
    }
}

if (!function_exists('checkUserRole')) {
    function checkUserRole($role):bool {
        $auth_role = authUserRole();
        $super_admin = ['super_admin'];
        $admin = ['super_admin', 'admin'];
        $manager = ['super_admin', 'admin', 'manager'];
        $storekeeper = ['super_admin', 'admin', 'manager', 'storekeeper'];
        return in_array($auth_role, $$role);
    }
}

if(!function_exists('makePositiveAmount')) {
    function makePositiveNumber($number):float {
        $number = $number + ($number * (-2));
        return $number;
    }
}
