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

class PaymentController extends Controller
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
    public function payment_list()
    {
        $payments = DB::select("SELECT payments.*, SUM(pay_logs.pay_amount) as totalPayAmount, users.name,users.user_name,users.email FROM payments LEFT JOIN users ON users.id = payments.user_id LEFT JOIN pay_logs ON pay_logs.payment_id = payments.id WHERE payments.is_pay = 2 AND payments.status = 'passive' GROUP BY payments.id");
 
        View::share(['payments' => $payments]);
        return view('admin.payment_list');
    }
    public function accept_payment($payment_id)
    {
        $payment = Payment::find($payment_id);
        if ($payment) {
            $payment_old = Payment::where('user_id',$payment->user_id)->where('status','active')->first();
        
            if ($payment_old) {
                $ekle = PaymentLog::create([
                    'id' => $payment_old->id,
                    'user_id' => $payment_old->user_id,
                    'package_id' => $payment_old->package_id,
                    'borsa' => $payment_old->borsa,
                    'type' => $payment_old->type,
                    'tx' => $payment_old->tx,
                    'usd_amount' => $payment_old->usd_amount,
                    'pay_amount' => $payment_old->pay_amount,
                    'is_pay' => $payment_old->is_pay,
                    'is_reference' => $payment_old->is_reference,
                    'is_binary' => $payment_old->is_binary,
                    'is_carr' => $payment_old->is_carr,
                    'payment_date' => $payment_old->payment_date,
                    'finish_date' => $payment_old->finish_date,
                    'status' => $payment_old->status,
                    'created_at' => $payment_old->created_at,
                    'updated_at' => $payment_old->updated_at
                ]);

                if ($ekle) {
                    $payment_old->delete();
                }
            }
            
            $calc_reference = Calc::calc_reference($payment_id);
            if ($calc_reference && $payment->status == 'passive' && $payment->is_pay == 2) {
                $payment->is_pay = 1;
                $payment->status = 'active';
                $payment->save();
                $user = User::find($payment->user_id);
                if ($user) {
                    $user->payment = 1;
                    $user->save();
                }
            }
        }
 
        return redirect()->route('payment_list');
    }

    public function reject_payment($payment_id)
    {
        $payment = Payment::find($payment_id);
        if ($payment) {
            if ($payment->status == 'passive' && $payment->is_pay == 2) {
                $payment->is_pay = 3;
                $payment->save();
            }
        }
 
        return redirect()->route('payment_list');
    }

    public function delete_payment($payment_id)
    {
        $payment = Payment::find($payment_id);
        if ($payment) {
            if ($payment->status == 'passive' && $payment->is_pay == 2) {
                $payment->delete();
            }
        }
 
        return redirect()->back();
    }
    
}
