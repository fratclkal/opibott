<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestNew;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Comission;
use App\Models\Binarypoint;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComissionsController extends Controller
{
  
    public function index(){
        $comissions = DB::select("SELECT comissions.*, SUM(comissions.usd_amount) as totalAmount FROM comissions WHERE user_id = ".Auth::user()->id." GROUP BY type");
        View::share('comissions',$comissions);
        return view('comissions');
    }
    public function comissions($type){
        $comissions = DB::select("SELECT comissions.*,  users.name FROM comissions LEFT JOIN users ON users.id = comissions.from_id WHERE comissions.user_id = ".Auth::user()->id." AND comissions.type = '".$type."' ");
        View::share(['comissions' => $comissions, 'type' => $type]);
        return view('comissions_detail');
    }
}
