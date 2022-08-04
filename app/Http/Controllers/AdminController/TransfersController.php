<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Calc;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Withdraws;
use App\Models\Comission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class TransfersController extends Controller
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
    public function all_transfer_list()
    {
        $transfers = DB::select("SELECT users.name,users.email,withdraws.id,withdraws.wallet,withdraws.amount,withdraws.type,withdraws.created_at,withdraws.status FROM withdraws LEFT JOIN users ON withdraws.user_id = users.id");
 
        View::share(['transfer' => $transfers]);
        return view('admin.all_transfers_list');
    }

    public function transfer_list()
    {
        $transfers = DB::select("SELECT users.name,users.email,withdraws.id,withdraws.wallet,withdraws.amount,withdraws.type,withdraws.created_at FROM withdraws LEFT JOIN users ON withdraws.user_id = users.id WHERE withdraws.status =2 GROUP BY withdraws.created_at;");
 
        View::share(['transfer' => $transfers]);
        return view('admin.transfers_list');
    }
 
    public function withdrawDelete($id){
        $check = Withdraws::where([
            'status'=>2,
            'id'=>$id
        ])->first();
        if ($check) {
            $check->status = 3;
            if ($check->save()) {
                return redirect()->route('transfer_list')->with('success','İşlem Başarılı!');
            }
            return redirect()->route('transfer_list')->with('error','İşlem Başarısız!');
        }
        
        return redirect()->route('transfer_list')->with('error','İşlem Başarısız!');      
        
    }

    public function withdrawAccept($id){
        $check = Withdraws::where([
            'status'=>2,
            'id'=>$id
        ])->first();
        
        if ($check) {
            if (!self::checkBallance($check->user_id)) {
                return redirect()->route('transfer_list')->with('error','Bu kullanıcının bakiyesi yok!');
            }
            $check->status = 1;
            if ($check->save()) {
                return redirect()->route('transfer_list')->with('success','İşlem Başarılı!');
            }
            return redirect()->route('transfer_list')->with('error','İşlem Başarısız!');
        }
        return redirect()->route('transfer_list')->with('error','İşlem Başarısız!');
        
    }
   
    private function checkBallance($user_id)
    {
        $comission = Comission::where([
            'user_id' => $user_id,
            'status' => "available"
        ])->sum("usd_amount");

        $withdraw = Withdraws::where('user_id', $user_id)->where('status','!=', 3)->sum("amount");

        $ballance = (double)$comission - (double)$withdraw;

        return $ballance >= 0 ? true : false;

    }
     
    
}
