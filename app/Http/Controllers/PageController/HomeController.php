<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Comission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        $referance_usdt = Comission::where([
            'user_id' => auth()->user()->id,
            'status' => 'available',
            'type' => 'REFERENCE',
        ])->sum("usd_amount");

        $binary_usdt = Comission::where([
            'user_id' => auth()->user()->id,
            'status' => 'available',
            'type' => 'BINARY',
        ])->sum("usd_amount");
        $matching_usdt = Comission::where([
            'user_id' => auth()->user()->id,
            'status' => 'available',
            'type' => 'MATCHING',
        ])->sum("usd_amount");

        $lastTeamMembers = User::orderBy('id', 'desc')->where([
            'upline_id' => auth()->user()->id
        ])->limit(5)->get();

        $comissions = Comission::where([
            'user_id' => auth()->user()->id,
            'status' => 'available',
        ])->limit(5)->get();

        $flashOutCalc = DB::select("SELECT COALESCE(SUM(usd_amount),0) as  usd_amount FROM `comissions` WHERE user_id=".Auth::user()->id." AND type='BINARY' AND created_at >= now() - INTERVAL 1 DAY");
        $kalanFlashOut = 1000 - $flashOutCalc[0]->usd_amount;
        if ($kalanFlashOut < 0) {
            $kalanFlashOut = 0;
        }
        View::share([
            'referance_usdt' => $referance_usdt,
            'binary_usdt' => $binary_usdt,
            'matching_usdt' => $matching_usdt,
            'lastTeamMembers' => $lastTeamMembers,
            'comissions' => $comissions,
            'flashOut' => $flashOutCalc[0]->usd_amount,
            'kalanFlashOut' => $kalanFlashOut
        ]);

        return view('index');
    }

}
