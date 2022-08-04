<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\GeneralMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\City;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    public static $userArr = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gsm', 'upline_id',
        'sponsor_id',
        'country', 'active', 'wallet', 'payment', 'user_id', 'binary_id', 'direction', 'rank', 'partner', 'partner_rate', 'user_name', 'robot',
        'btcwallet', 'role', 'city', 'is_carr', 'carier', 'encrypt','uyruk'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'photo_url',
    ];
   
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $table = 'users';

    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
    }

    public function getRate($userId)
    {
        $rt = [];
        $amount_usd = 0.0;
        $amount_wcs = 0.0;
        $amount_btc = 0.0;
        $amount = 0.0;
        $pymt = Payment::where('user_id', $userId)->where('is_pay', 1)->get();//  Client[:payments].find({user_id: userId, is_pay: 1})
        foreach ($pymt as $item) {
            $amount_usd += (float)$item['usd_amount'];
            $amount += (float)$item['usd_amount'];
            $amount_wcs += (float)$item['wcs_amount'];
            $amount_btc += (float)$item['btc_amount'];
        }
        /*
        if ($amount > 4900 && $pymt[0]['created_at'] < '2020-03-01') {
            $user = User::find($userId);
            if($user){
              if
            }
        }*/
        //$rate = Monthly_bonus::whereRaw(['min_pay' => ['$lte' => $amount]])->whereRaw(['max_pay' => ['$gt' => $amount]])->first();//  Client['monthly_bonus'].find({min_pay: {'$lte': amount}, max_pay: {'$gt': amount}}).first
        $rate = Monthly_bonus::where('min_pay', '<', $amount)->where('max_pay', '>', $amount)->first();

        if (isset($rate)) {
            $tt = $rate->rate_reference;
            if ($amount > 4900 && Carbon::parse($pymt[0]['created_at'])->format('Y-m-d') < Carbon::parse('2020-03-01')->format('Y-m-d')) {
                $user = User::find($userId);
                if($user){
                  if($user->country_id != 223){
                    $rate->rate_reference = 20;
                    $rate->rate_binary = 12;
                    $rate->rate_monthly = 8;
                    $tt = $rate->rate_reference;
                  }
                }
            }
            array_push($rt, array('rate_reference' => (float)$rate->rate_reference, 'rate_binary' => (float)$rate->rate_binary, 'rate_monthly' => (float)$rate->rate_monthly, 'amount_usd' => (float)$amount_usd, 'amount_wcs' => (float)$amount_wcs, 'amount_btc' => (float)$amount_btc, 'rate_leader' => (float)$rate->leader));
        }
        if(empty($rt)){
            return 0;
        }
        return $rt[0];
    }

    public function getRate2($userId)
    {
        $rt = [];
        $amount_usd = 0.0;
        $amount_wcs = 0.0;
        $amount_btc = 0.0;
        $amount = 0.0;
        $pymt = Payment::where('user_id', $userId)->where('is_pay', 1)->get();//  Client[:payments].find({user_id: userId, is_pay: 1})
        foreach ($pymt as $item) {
            $amount_usd += (float)$item['usd_amount'];
            $amount += (float)$item['usd_amount'];
            $amount_wcs += (float)$item['wcs_amount'];
            $amount_btc += (float)$item['btc_amount'];
        }

        //$rate = Monthly_bonus::whereRaw(['min_pay' => ['$lte' => $amount]])->whereRaw(['max_pay' => ['$gt' => $amount]])->first();//  Client['monthly_bonus'].find({min_pay: {'$lte': amount}, max_pay: {'$gt': amount}}).first
        $rate = Monthly_bonus::where('min_pay', '<', $amount)->where('max_pay', '>', $amount)->first();

        if (isset($rate)) {
            $tt = $rate->rate_reference;
            array_push($rt, array('rate_reference' => (float)$rate->rate_reference,
                'rate_binary' => (float)$rate->rate_binary,
                'rate_monthly' => (float)$rate->rate_monthly,
                'amount_usd' => (float)$amount_usd,
                'amount_wcs' => (float)$amount_wcs,
                'amount_btc' => (float)$amount_btc,
                'rate_leader1' => $rate->leader_lev_1,
                'rate_leader2' => $rate->leader_lev_2,
                'rate_leader3' => $rate->leader_lev_3,
                'rate_leader4' => $rate->leader_lev_4,
            ));
        }
        if(empty($rt)){
            return 0;
        }
        return $rt[0];
    }

    public function getUnilevelUpline($userId)
    {
        $usr = DB::select('SELECT  @id :=
          (
            SELECT  upline_id
            FROM    users
            WHERE   id = @id
            ) AS person,
            id, upline_id
            FROM    (
              SELECT  @id := ' . $userId . '
              ) vars
              STRAIGHT_JOIN
              users
              WHERE   @id IS NOT NULL and id <> 0 ;');
        return $usr;
    }

    public function getBinary($userId, $depth = 3)
    {
        $usr = User::raw(function ($collection) use ($userId, $depth) {
            return $collection->aggregate([
                ['$project' => [
                    'id' => 1,
                    'binary_id' => 1
                ]],
                [
                    '$graphLookup' => [
                        'from' => 'users',
                        'startWith' => '$id',
                        'connectFromField' => 'id',
                        'connectToField' => 'binary_id',
                        'depthField' => 'depth',
                        'as' => 'ancestors',
                        'maxDepth' => $depth,
                    ]
                ],
                ['$match' => ['id' => $userId]],
                ['$unwind' => '$ancestors'],
                ['$sort' => ['ancestors.depth' => 1]]

            ]);
        });
        return $usr;
    }

    public function getBinaryUpline($userId)
    {

        $users = DB::select('
        SELECT  @id :=
          (
            SELECT  binary_id
            FROM    users
            WHERE   id = @id and binary_id <> 0 and binary_id is not null
            ) AS person,
            id, sponsor_id
            FROM    (
              SELECT  @id := ' . $userId . '
              ) vars
              STRAIGHT_JOIN
              users
              WHERE   @id IS NOT NULL and id <> 0;');
        return $users;

    }
    public static function getBinaryLine($userId)
    {

        $users = DB::select('
        SELECT  @id :=
          (
            SELECT  binary_id
            FROM    users
            WHERE   id = @id and binary_id <> 0 and binary_id is not null
            ) AS person,
            id, sponsor_id
            FROM    (
              SELECT  @id := ' . $userId . '
              ) vars
              STRAIGHT_JOIN
              users
              WHERE   @id IS NOT NULL and id <> 0;');
        return $users;

    }

    public function getunilevelList($userId, $depth = 0, $unilevellist = [])
    {

        $usr = User::where('id',$userId)->get();
        foreach ($usr as $f) {

            $gg = $this->getRate2($userId);
            $gg1 = 0;
            $rate_montly = 0;
            $rate_montly = isset($gg['rate_monthly']) ? $gg['rate_monthly'] : 0;
            if ($depth == 0) $gg1 = isset($gg['rate_leader1']) ? $gg['rate_leader1'] : 0;
            if ($depth == 1) $gg1 = isset( $gg['rate_leader2']) ?  $gg['rate_leader2'] : 0;
            if ($depth == 2) $gg1 = isset($gg['rate_leader3']) ? $gg['rate_leader3'] : 0;
            array_push($unilevellist, [
                'user_id' => (int)$f['id'],
                'upline_id' => (int)$f['upline_id'],
                'name' => $f['name'],
                'payment' => $f['payment'],
                'depth' => $depth,
                'rate' => $gg1,
                'rate_monthly' => $rate_montly,
            ]);
            $depth += 1;
            self::getunilevelList((int)$f['id'],$depth,$unilevellist);
        }
        return $unilevellist;
    }
    public static function myteamcalc($firstID,$depth = 0,$children = []){
        if($depth > 2){
            return $children;
        }
        $firstLineUsers = User::where('upline_id',$firstID)->where('active',1)->get();
        if($firstLineUsers){
            foreach ($firstLineUsers as $child) {
                $child->depth = $depth;
                array_push($children,$child);
                $children = self::myteamcalc($child->id,$depth+1, $children);
            }

        }
        //dd($firstLineUsers);

        return $children;
    }
    public function LeaderCalc($user_id,$payment,$wcskur,$btckur,$currontMonthdays,$month,$year,$day,$week){
           $users =  self::myteamcalc($user_id);
           foreach ($users as $user){
               $amount_usd = 0.0;
               $amount_wcs = 0.0;
               $amount_btc = 0.0;
                $userpassive = Leader::where("type","PASSIVE")->where('user_id',$user->id)->whereDate("created_at",date("Y-m-d"))->first();
                if(empty($userpassive)) continue;
                if($user['depth']==0){
                    $rate = Monthly_bonus::where('min_pay', '<', $payment)->where('max_pay', '>=', $payment)->first()->leader_lev_1;
                }
                else if($user['depth']==1){
                    $rate = Monthly_bonus::where('min_pay', '<', $payment)->where('max_pay', '>=', $payment)->first()->leader_lev_2;
                }
                else if($user['depth']==2){
                    $rate = Monthly_bonus::where('min_pay', '<', $payment)->where('max_pay', '>=', $payment)->first()->leader_lev_3;
                }

               $deservesmonth = (($userpassive->usd_value * $rate) / 100);
               $deservesdayusd = $deservesmonth ;
               $deservesdaywcs = $deservesdayusd / $wcskur;
               $deservesdaybtc = $deservesdayusd / $btckur;

               Leader::create([
                   'user_id' => $user_id,
                   'usd_value' => $deservesdayusd,
                   'wcs_value' => $deservesdaywcs,
                   'btc_value' => $deservesdaybtc,
                   'rate' => $rate,
                   'month' => $month,
                   'week' => $week,
                   'year' => $year,
                   'date' => $day,
                   'from_id' => $user['id'],
                   'type' => "LEADER",
                   'depth' => $user['depth'],
                   'usd_kuru' => $wcskur,
                   'created_at' => date("Y-m-d H:i:s"),
                   'wgc_kur' => (float)GeneralMethods::getWeeGoldUSDTValue(),
                   'wgc_amount' =>  ($deservesdayusd*35/100)/(float)GeneralMethods::getWeeGoldUSDTValue(),
                   'wcs_kesinti' =>  $deservesdaywcs*35/100,
               ]);
               GeneralMethods::createFarmingWallet($user_id,$deservesdayusd*35/100,$deservesdaywcs*35/100,$deservesdaybtc*35/100,$wcskur,'LEADER');
               $comission = Comission::where([
                   ['user_id', '=', $user_id],
                   ['type', '=', 'LEADER'],
                   ['month', '=', $month],
                   ['year', '=', $year],
               ])->first();
               if (empty($comission)) {
                   Comission::create([
                       'user_id' => $user_id,
                       'usd_value' => $deservesdayusd,
                       'wcs_value' => $deservesdaywcs,
                       'wcs_degeri' => $deservesdaywcs,
                       'btc_value' => $deservesdaybtc,
                       'rate' => $rate,
                       'month' => $month,
                       'week' => $week,
                       'year' => $year,
                       'date' => $day,
                       'from_id' => $user->id,
                       'type' => "LEADER",
                       'depth' => $user['depth'],
                       'usd_kuru' => $wcskur,
                       'paytype' => 'wcs',
                   ]);
               } else {
                   $comission->wcs_value = ($comission->wcs_value + $deservesdaywcs);
                   $comission->wcs_degeri = ($comission->wcs_degeri + $deservesdaywcs);
                   $comission->btc_value = ($comission->btc_value + $deservesdaybtc);
                   $comission->usd_value = ($comission->usd_value + $deservesdayusd);
                   $comission->usd_kuru = $wcskur;
                   $comission->save();
               }
           }
    }

    public static function countryGet($id){
        return Country::find($id)->name ?? null;
    }
    public static function cityGet($id){
        return City::find($id)->name ?? null;
    }

    public static function userNameGet($id){
        return User::find($id)->name ?? null;
    }

}
