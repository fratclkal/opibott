<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\PaymentLog;
use App\Models\PayLog;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Carbon\Carbon;
 
class PaymentController extends Controller
{
    public function pricing($borsa = null)
    {
        $payment_exist = Payment::where('user_id',Auth::user()->id)->where('status','passive')->first();
        if ($payment_exist) {
            return redirect()->route('payment_await');
        }
        $package_amount = Payment::where('user_id',Auth::user()->id)->where('status','active')->where('is_pay',1)->sum('usd_amount');
        
        $all_packages = Package::where('package_amount','>',$package_amount)->get();

        View::share(['all_packages' => $all_packages, 'borsa' => $borsa]);
        return view('pricing');
    }
    public function select_package($package_id,$borsa = null)
    {
        if (!$borsa) {
            return redirect('pricing')->with('error','Lütfen borsa seçimi yapınız!');
        }
        $payment_exist = Payment::where('user_id',Auth::user()->id)->where('status','passive')->first();
        if ($payment_exist) {
            return redirect()->route('payment_await')->with('error','Mevcut seçili bir paketiniz varken yeni bir paket seçimi yapamazsınız!');
        }
        
        $package = Package::find($package_id);
        
        if ($package) {
            $ekle = Payment::create([
                'user_id' => Auth::user()->id,
                'package_id' => $package_id,
                'borsa' => $borsa,
                'type' => $package->type,
                'usd_amount' => $package->package_amount,
                'is_pay' => 0,
                'status' => 'passive',
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);

            if ($ekle) {
                return redirect(route('payment_await'));
            }
            return redirect(route('pricing'))->with('error','Paket seçiminde bir hata meydana geldi. Lütfen tekrar deneyin!');
        }
        return redirect(route('pricing'))->with('error','Paket seçilemedi. Lütfen tekrar deneyin!');
    }
    public function payment_await()
    {
        $payment = Payment::where('user_id',Auth::user()->id)->where('status','passive')->first();
        if ($payment) {
            $package = Package::find($payment->package_id);
            if ($package) {
                $totalPayment = PayLog::where('user_id',Auth::user()->id)->where('payment_id',$payment->id)->sum('pay_amount');
                View::share(['payment' => $payment, 'package' => $package, 'totalPayment' => $totalPayment]);
                return view('payment_await');
            }else{
                if ($payment->delete()) {
                    return redirect()->back()->with('error','Yanlış paket seçiminizi yaptınız. Lütfen tekrar seçim yapın!');
                }
            }

        }
        if (Auth::user()->payment == 1) {
            return redirect(route('homePage'));
        }
        return redirect(route('pricing'))->with('error','Paket seçilemedi. Lütfen tekrar deneyin!');
    }
    public function delete_package($payment_id)
    {
        $payment_exist = Payment::where('id',$payment_id)->where('status','passive')->where('is_pay',0)->first();
        if ($payment_exist) {
            if ($payment_exist->delete()) {
                return redirect()->route('pricing')->with('error','Silme işleminiz başarılı. Lütfen yeni bir paket seçin!');
            }else{
                return redirect()->back()->with('error','İşlem başarısız. Lütfen tekrar deneyin!');
            }
            
        }else{
            return redirect()->back()->with('error','Aktif veya biten paketlerinizi silemezsiniz!');
        }

    }
    public function pay_package(Request $request)
    {
        $request->validate([
            'tx' => 'required|min:64|max:64|unique:payments'
        ]);
        $payment = Payment::where('id',$request->payment_id)->where('status','passive')->first();
        if ($payment) {
            $client = new Client();

            $result = $client->request('GET','https://apilist.tronscan.org/api/transaction-info?hash='.$request->tx);

            $tronscan_payment = json_decode($result->getBody());
            //dd($tronscan_payment);
            $status = $tronscan_payment->contractRet;
            $pay_amount = isset($tronscan_payment->transfersAllList[0]->amount_str) ? (float)$tronscan_payment->transfersAllList[0]->amount_str/1000000:0;
            $to_address = isset($tronscan_payment->transfersAllList[0]->amount_str->to_address) ? $tronscan_payment->transfersAllList[0]->amount_str->to_address:'';
            /*
            if ($to_address == 'TSC5qCiWLCCfJc9Dj4hZ7mvizagHtw1gBm') {
                
            } 
            */
            if ($pay_amount > 0) {
                PayLog::create([
                    'user_id' => Auth::user()->id,
                    'payment_id' => $request->payment_id,
                    'pay_amount' => $pay_amount,
                    'tx' => $request->tx,
                    'created_at' => date('Y-m-d h:i:s'),
                ]);
            }

            $payment->is_pay = 2;
            $payment->tx = $request->tx;
            $payment->pay_amount = $pay_amount;
            $payment->payment_date = date('Y-m-d h:i:s');

            if($payment->save()){
                return redirect()->back()->with('success','İşlem başarılı ödemeniz kontrol edildikten sonra sistem tarafından onaylanacaktır!');
            }else{
                return redirect()->back()->with('error','İşlem başarısız. Lütfen tekrar deneyin!');
            }
        }else{
            return redirect()->back()->with('error','Ödeme bekleyen bir paketiniz bulunmamaktadır!');
        }


    }
    public function testPayment(){
        $client = new Client();

            $result = $client->request('GET','https://apilist.tronscan.org/api/transaction-info?hash=649dd4d0b23f7c1e327a40a5d4f46626ac9231c940d0893b3abe006d8634f3f4');

            $tronscan_payment = json_decode($result->getBody());
            dd($tronscan_payment->transfersAllList[0]);
    }
}
