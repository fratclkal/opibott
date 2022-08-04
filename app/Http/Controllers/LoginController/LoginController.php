<?php

namespace App\Http\Controllers\LoginController;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class LoginController extends Controller
{ 
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('homePage');
        }else{
            return redirect()->back()->with('error','Giriş yapılamadı. Lütfen girdiğiniz bilgilerin doğruluğundan emin olunuz!');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('loginView');
    }
    public function getCity(Request $request)
    {
        $cities = City::where('country_id', $request->id)->get();
        return $cities;
    }
    public function registerView($ref_code = null){
        $upline_id_exist = User::where('sponsor_id',$ref_code)->first();
        if (!$upline_id_exist && $ref_code != null) {
            return redirect()->route('loginView');
        }
        $countries = Country::orderBy('firstly','DESC')->get();
        View::share(['countries' => $countries,'ref_code' => $ref_code]);
        return view('auth.register');
    }
    public function registerPost(Request $request){
        $request->flash();
        $request->validate([
            'name' => 'required',
            'ref_code' => 'required',
            'email' => 'required|email|unique:users,email',
            'user_name' => 'required|unique:users,user_name',
            'password' => 'required|min:8'
        ]);
        $upline_id_exist = User::where('sponsor_id',$request->ref_code)->first();
        if (!$upline_id_exist) {
            return redirect()->back()->with('error','Bu referans koduna ait bir kullanıcı bulunamadı!');
        }elseif ($upline_id_exist->payment == 0) {
            return redirect()->back()->with('error','Bu kullanıcının referansıyla kayıt olunamaz!');
        }
        $new = User::create([
            'name'=> $request->name,
            'email'=> strtolower($request->email),
            'password'=> Hash::make($request->password),
            'user_name'=> $request->user_name,
            'gsm'=> $request->gsm,
            'upline_id'=> $upline_id_exist->id,
            'sponsor_id'=> self::create_sponsor_id(),
            'country'=> $request->country,
            'city'=> $request->city,
            'career'=> 0,
            'payment'=> 0,
            'active'=> 1,
            'role'=> 'client',
            'sozlesme'=> 1,
            'aydinlatma_metni'=> 1,
            'created_at'=> date('Y-m-d h:i:s'),
            'updated_at'=> date('Y-m-d h:i:s'),
        ]);

        if($new){
            $mail = array(
                'title' => "OpiBot - Yeni Kullanıcı",
                'name' => $request->name,
                'view' => 'mails.new_member'
            );
            Mail::to(strtolower($request->email))->send(new SendMail($mail));
            return redirect()->route('loginView')->with('success','Kayıt işleminiz başarılı.');
        }else{
            return redirect()->back()->with('error','Kayıt işleminiz başarısız. Lütfen alanları eksiksiz girdiğinizden emin olun.');
        }
    }
    public static function create_sponsor_id(){
        $sponsor_id = mt_rand(100000000,999999999);
        $sponsor_exist = DB::table('users')->where('sponsor_id',$sponsor_id)->first();
        if ($sponsor_exist) {
            $sponsor_id = self::create_sponsor_id();
        }
        return $sponsor_id;
    }
    public function forgot_password(){
        return view('auth.forgot_password');
    }
    public function forgot_password_post(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email',$request->email)->first();
        if(!$user) return redirect()->route('forgot_password')->with('error', "Böyle bir email adresi bulunmamaktadır!");
        $token = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 16);
        $user->token = $token;
        $user->save();
        $mail = array(
            'title' => "OpiBot - Şifre sıfırla",
            'name' => $user->name,
            'email' => strtolower($user->email),
            'token' => $token,
            'view' => 'mails.pass_reset'
        );
        Mail::to(strtolower($request->email))->send(new SendMail($mail));
        return redirect()->route('forgot_password')->with('success', "İşlem başarılı. Lütfen email adresinizi kontrol ediniz!");
    }
    public function reset_password($email,$token){
        $user = User::where(['email'=>$email,'token'=>$token])->first();
        if (!$user) return redirect()->back();
        return view('auth.reset_password',compact('email','token'));
    }
    public function reset_password_post(Request $request){
        $user = User::where(['email'=>$request->email,'token'=>$request->token])->first();
        if (!$user) return redirect()->back();
        $request->validate([
            'password' => 'required|confirmed|min:8'
        ]);
        $user->password = Hash::make($request->password);
        $user->token = null;
        if($user->save())
        return redirect()->route('loginView')->with('success', "Şifre sıfırlama işleminiz başarılı. Giriş yapabilirsiniz.");
        else return redirect()->back()->with('error', "İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin!");

    }
}
