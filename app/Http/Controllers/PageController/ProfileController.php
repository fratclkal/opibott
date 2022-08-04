<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class ProfileController extends Controller
{

    public function profileIndex(){
        return view('profile');
    }
    public function profileEdit(Request $request){


        /*
         * Pass Reset
         * */
        $request->validate([
            'currentpassword' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ]);
        $user = User::find(Auth::user()->id);
        if(Hash::check($request->currentpassword,$user->password)){
            $user->password = Hash::make($request->password);
            if($user->save()){
                return redirect()->back()->with('success','İşlem başarıyla gerçekleştirildi!');
            }
            return redirect()->back()->with('error','Beklenmedik bir hata oluştu!');
        }else{
            return redirect()->back()->with('error',"Eski şifre eşleşmedi!");
        }
    }
}
