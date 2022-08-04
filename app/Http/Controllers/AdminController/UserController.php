<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Calc;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{ 
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role =='superadmin' || Auth::user()->role =='admin') {
                return $next($request);
            }else{
                return redirect(route('homePage'));
            }
            
        });
        
    }
    public function user_list()
    {
        $allusers = DB::select("SELECT users.name,users.user_name,users.email,users.upline_id,users.sponsor_id,users.payment,payments.usd_amount,payments.payment_date,payments.borsa FROM users LEFT JOIN payments ON users.id = payments.user_id WHERE users.active = 1 GROUP BY users.id;");
 
        View::share(['users' => $allusers]);
        return view('admin.user_list');
    }

    public function user_bot_list()
    {
        $allusers = DB::select("SELECT users.name, users.email, payments.borsa, user_bot_settings.api_key, user_bot_settings.api_secret, user_bot_settings.active as status FROM users JOIN user_bot_settings ON user_bot_settings.user_id = users.id JOIN payments ON users.id = payments.user_id GROUP BY users.id;");
 
        View::share(['users' => $allusers]);
        return view('admin.user_bot_list');
    }
 
    
}
