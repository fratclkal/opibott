<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestNew;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Comission;
use App\Models\Withdraws;
use App\Models\Binarypoint;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComissionsController extends Controller
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
    public function index(){
        $comissions = DB::select("SELECT users.name,users.email,users.sponsor_id, comissions.*, SUM(comissions.usd_amount) as totalAmount FROM comissions INNER JOIN users ON users.id = comissions.user_id  GROUP BY comissions.user_id,comissions.type ORDER BY comissions.user_id");
        
        View::share('comissions',$comissions);
        return view('admin.comissions');
    }
    public function comissions($user_id,$type){
        $comissions = DB::select("SELECT comissions.*, users.name, users.email FROM comissions LEFT JOIN users ON users.id = comissions.from_id WHERE comissions.user_id = ".$user_id." AND comissions.type = '".$type."' ");
        View::share(['comissions' => $comissions, 'type' => $type, 'user_id' => $user_id]);
        return view('admin.comissions_detail');
    }

    public function users_balance(){
        $users = DB::select("SELECT users.*, (SELECT SUM(usd_amount) FROM comissions WHERE comissions.user_id = users.id) as usd_amount, (SELECT SUM(amount) FROM withdraws WHERE withdraws.user_id = users.id AND withdraws.status = 1) as withdraw_amount, (SELECT SUM(amount_fee) FROM withdraws WHERE withdraws.user_id = users.id AND withdraws.status = 1) as fee_amount FROM users");
        View::share('users',$users);
        return view('admin.users_balance');
    }
    public function total_turnover(){
        $total_package_info = DB::select("SELECT SUM(usd_amount) as usd_amount,COUNT(id) as package_count FROM payments WHERE is_pay = 1");

        $last20_package = DB::select("SELECT package_count FROM ( SELECT COUNT(id) as package_count,DATE(created_at) as day FROM payments WHERE is_pay = 1 GROUP BY DATE(created_at) ORDER BY id DESC LIMIT 20 ) sub ORDER BY day ASC");

        $total_comission_info = DB::select("SELECT SUM(usd_amount) as usd_amount,(SELECT COUNT(count) FROM (SELECT COUNT(from_id) AS count FROM comissions GROUP BY from_id) as A) as user_count FROM comissions");

        $last20_comission = DB::select("SELECT comission_count FROM ( SELECT COUNT(id) as comission_count,DATE(created_at) as day FROM comissions GROUP BY DATE(created_at) ORDER BY id DESC LIMIT 20 ) sub ORDER BY day ASC");

        $withdraw_info = DB::select("SELECT SUM(amount) as withdraw_amount, SUM(amount_fee) as fee_amount FROM withdraws WHERE status = 1");

        $last20_withdraw = DB::select("SELECT withdraw_count FROM ( SELECT COUNT(id) as withdraw_count,DATE(created_at) as day FROM withdraws WHERE status = 1 GROUP BY DATE(created_at) ORDER BY id DESC LIMIT 20 ) sub ORDER BY day ASC");

        $payments = DB::select("SELECT SUM(payments.usd_amount) as total_amount, COUNT(payments.id) as package_count,packages.type as type, packages.package_amount as package_amount, packages.max_amount as max_amount, payments.is_pay FROM payments JOIN packages ON payments.package_id = packages.id GROUP BY payments.package_id,payments.is_pay");

        $comissions = DB::select("SELECT type, SUM(comissions.usd_amount) as total_amount, COUNT(comissions.type) as type_count FROM comissions GROUP BY type");
        
        View::share([
            'total_package_info' => $total_package_info,
            'last20_package' => $last20_package,
            'total_comission_info' => $total_comission_info,
            'withdraw_info' => $withdraw_info,
            'last20_comission' => $last20_comission,
            'last20_withdraw' => $last20_withdraw,
            'payments' => $payments,
            'comissions' => $comissions
        ]);
        return view('admin.total_turnover');
    }
}
