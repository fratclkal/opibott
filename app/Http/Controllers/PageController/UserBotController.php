<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Comission;
use App\Models\Payment;
use App\Models\UserBotSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class UserBotController extends Controller
{

    public function index()
    {
        $setting = UserBotSetting::where('user_id',Auth::user()->id)->first();
        $payment = Payment::where('user_id',Auth::user()->id)->first();
        View::share([
            'setting' => $setting,
            'payment' => $payment
        ]);
        return view('user_bot_settings');
    }
    public function settings(Request $request){
        $request->validate([
            'api_key' => 'required'
        ]);
        $setting = UserBotSetting::where('user_id',Auth::user()->id)->first();
        if ($setting) {
            $setting->api_key = $request->api_key;
            $setting->api_secret = $request->api_secret;
            $setting->ip_address = $request->ip_address;
            if ($setting->save()) {
                return redirect()->route('user_bot_settings')->with('success','24 saat ile 72 saat arasında kurulumunuz tamamlanacaktır.');
            }
            return redirect()->route('user_bot_settings')->with('error','İşlem başarısız.');
        }else{
            $ekle = UserBotSetting::create([
                'user_id' => Auth::user()->id,
                'api_key' => $request->api_key,
                'api_secret' => $request->api_secret,
                'ip_address' => $request->ip_address,
                'active' => Auth::user()->payment,
            ]);
            if ($ekle) {
                return redirect()->route('user_bot_settings')->with('success','24 saat ile 72 saat arasında kurulumunuz tamamlanacaktır.');
            }
            return redirect()->route('user_bot_settings')->with('error','İşlem başarısız.');
        }

    }
}
