<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class isPayment
{

    public function handle(Request $request, Closure $next)
    {
        $payment = Payment::where('user_id',Auth::user()->id)->where('status','!=','ended')->first();
        if ($payment) {
            if ($payment->status == 'active') {
                return $next($request);
            }else{
                return redirect()->route('payment_await');
            }
        }else{
            return redirect()->route('pricing');
        }
        
        
    }
}
