<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestNew;
use App\Models\Payment;
use App\Models\Withdraws;
use App\Models\Comission;
use App\Models\User;
use App\Models\Userwallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;
 
class WalletController extends Controller
{

    public function walletIndex()
    {
        $user_id = auth()->user()->id;

        $Payment = Payment::where([
            'user_id' => $user_id,
            'is_pay' => 1,
            'status' => "active",
        ])->first();

        $comissionsDetails = Comission::where([
            'user_id' => $user_id,
            'status' => "available"
        ])->get();

        $withdrawsDetails = Withdraws::where([
            'user_id' => $user_id,
        ])->get();


        $comissionsValue = 0;
        $withdrawsValue = 0;

        foreach ($comissionsDetails as $comission) {
            $comissionsValue += $comission->usd_amount;
        }
        foreach ($withdrawsDetails as $withdraw) {
            $withdrawsValue += $withdraw->amount;
        }

        $available_amount = (double)$comissionsValue - (double)$withdrawsValue;
        $user_wallet_info = Userwallet::where('type','usd')->where('user_id',Auth::user()->id)->get();
        View::share([
            'available_amount' => $available_amount,
            'comissions' => $comissionsDetails,
            'withdraws' => $withdrawsDetails,
            'payment' => $Payment,
            'user_wallet_info' => $user_wallet_info,
        ]);

        return view('wallet');
    }

    public function myWallets(){
        $user_wallet_info = Userwallet::where('type','usd')->where('user_id',Auth::user()->id)->get();
        View::share([
            'user_wallet_info' => $user_wallet_info
        ]);

        return view('my_wallets');
    }

    public function myWalletsPost(Request $request){
        $user_wallet_info = Userwallet::where('type','usd')->where('user_id',Auth::user()->id)->first();
        if ($user_wallet_info) {
            if (Hash::check($request->password, $user_wallet_info->password)) {
                $user_wallet_info->address = $request->address;
                if ($user_wallet_info->save()) {
                    return redirect()->route('myWallets')->with('success','Adres güncelleme işlemi başarılı!');
                }else{
                    return redirect()->route('myWallets')->with('error','İşlem sırasında bir hata meydana geldi. Lütfen tekrar deneyin!');
                }
            }else{
                return redirect()->route('myWallets')->with('error','Adres şifrenizi yanlış girdiniz!');
            }
        }else{
            $password = Hash::make($request->password);
            $ekle = Userwallet::create([
                'user_id' => Auth::user()->id,
                'type' => 'usd',
                'address' => $request->address,
                'password' => $password,
            ]);
            if ($ekle) {
                return redirect()->route('myWallets')->with('success','Adres ekleme işlemi başarılı!');
            }else{
                return redirect()->route('myWallets')->with('error','İşlem sırasında bir hata meydana geldi. Lütfen tekrar deneyin!');
            }
        }

        return redirect()->route('myWallets')->with('success','İşlem başarılı');
    }

    public function withdraw(Request $request)
    {

        $request->validate([
            'address' => 'required',
            'password' => 'required',
            'amount' => 'required|numeric|min:10',
        ]);
        $user_wallet_info = Userwallet::where('type','usd')->where('user_id',Auth::user()->id)->first();
        if ($user_wallet_info) {
            if (!Hash::check($request->password, $user_wallet_info->password)) {
                return redirect()->back()->with('error', "Adres şifrenizi yanlış girdiniz!");
            }
        }

        /// Balance Control method
        if (!self::checkBallance($request->amount)) {
            return redirect()->back()->with('ballanceError', true);
        }

        $token = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 64);

        $addWithdraw = Withdraws::create([
            'user_id' => auth()->user()->id,
            'status' => 0,
            'type' => 'transfer',
            'amount' => $request->amount,
            'amount_fee' => number_format($request->amount * 0.10, 2) + 3, // %10 + 3
            'wallet' => $request->address,
            'usd_amount' => $request->amount,
            'token' => $token,
        ]);

        if ($addWithdraw) {
            $mail = array(
                'title' => "Opi Bot - Transfer Onay",
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'token' => $token,
                'withdraw_id' => $addWithdraw->id,
                'wallet' => $request->address,
                'amount' => $request->amount,
                'fee' => number_format($request->amount * 0.10, 2) + 3, // %10 + 3
                'view' => 'mails.new_transfer'
            );
            Mail::to(strtolower(auth()->user()->email))->send(new SendMail($mail));
            return redirect()->back()->with('sendMailWithdraw', true);
        } else {
            return redirect()->back()->with('error', true);
        }
    }

    public function withdrawConfirmation($withdraw_id,$token){
        $check = Withdraws::where([
            'id'=>$withdraw_id,
            'token'=>$token,
            'status'=>0,
        ])->first();
        if($check){
            $check->status = 2;
            return redirect()->route('WalletIndex')->with($check->save() ? 'succesConfirmation' : 'error',true);
        }else{
            return redirect()->route('WalletIndex')->with('error',true);
        }
    }

    public function withdrawDelete($id){
        
        $check = Withdraws::where([
            'user_id'=>auth()->user()->id,
            'status'=>0,
            'id'=>$id,
        ])->first();

        return redirect()->route('WalletIndex')->with($check && $check->delete() ? 'succesDelete' : 'error',true);
    
        
    }

    public function withdrawAccept($id){
        if (Auth::user()->role == 'superadmin') {
            $check = Withdraws::where([
                'status'=>2,
                'id'=>$id
            ])->first();
            
            if ($check) {
                $check->status = 1;
                if ($check->save()) {
                    return redirect()->route('transfer_list')->with('success','İşlem Başarılı!');
                }
                return redirect()->route('transfer_list')->with('error','İşlem Başarısız!');
            }
            return redirect()->route('transfer_list')->with('error','İşlem Başarısız!');
        }
        return redirect()->back()->with('error','Bu işlem için yetkiniz yoktur!');
    }

    private function checkBallance($amount)
    {
        $user_id = auth()->user()->id;
        $comission = Comission::where([
            'user_id' => $user_id,
            'status' => "available"
        ])->sum("usd_amount");

        $withdraw = Withdraws::where('user_id', $user_id)->where('status','!=', 3)->sum("amount");

        $ballance = (double)$comission - (double)$withdraw;

        return $ballance >= $amount ? true : false;

    }

}
