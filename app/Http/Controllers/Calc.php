<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Package;
use App\Models\Comission;
use App\Models\Binarylog;
use App\Models\Binarypoint;
use App\Models\User;
use App\Models\RankLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Calc extends Controller
{

    public static function calc_reference($payment_id)
    {
        $payment = Payment::find($payment_id);
        if ($payment->is_reference == 0) {
            $payment->is_reference = 1;
            if ($payment->save()) {
                $date = Carbon::now();
                $day = $date->day;
                $week = $date->week;
                $month = $date->month;
                $year = $date->year;

                $user = User::find($payment->user_id);
                $upline_user = User::find($user->upline_id);
                $ekle = Comission::create([
                    'user_id' => $upline_user->id,
                    'from_id' => $user->id,
                    'usd_amount' => $payment->usd_amount*10/100,
                    'type' => 'REFERENCE',
                    'depth' => 0,
                    'day' => $day,
                    'week' => $week,
                    'month' => $month,
                    'year' => $year,
                    'rate' => 10,
                    'status' => 'available',
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s')
                ]);
                if ($ekle) {
                    return true;
                }
                return false;
            }
        }

    }
    public static function send_payment_confirmation_binary($id)
    {
        $usr = Payment::where('user_id', (integer)$id)->where('is_pay', 1)->get();
        //Rank_calc::calc_rank_team($id);
        $user = array();
        $binary_status = 1;
        foreach ($usr as $pym) {
            $user_id = $pym->user_id;
            $urt = new \App\Models\User();
            // $dd = $urt->getRate($user_id);

            $user = User::where('id', $user_id)->first();
            $direction = $user->direction;
            $is_binary = $pym->is_binary;
            $binary1 = $is_binary == 0;
            $binary2 = (string)$direction != '0';
            if ($binary1 && $binary2) {
                $pym->is_binary = 1;
                $pym->save();

                $binary_status = self::add_comission_binary_upline($user_id,$user->direction,(float)$pym->usd_amount);
            }
            $pym->save();
        }
        $calc_career_status = self::calcCareerAllUsers();
        return $binary_status;
    }

    public static function add_comission_binary_upline($id, $direction = 2, $usd_value = 0, $type = 'Register')
    {
        $point = $usd_value;
        $prim_tot = 0;
        $usr = new User();
        $user = $usr->getBinaryUpline($id);
        $count = count($user);
        $i = 0;
        foreach ($user as $data) {
            if ($data->person == null || $data->person == 0) {
                continue;
            }
            $depth = 0;
            $binarylog = new Binarylog;
            $binarylog->user_id = (integer)$data->person;
            $binarylog->from_id = (integer)$id;
            $binarylog->point = (float)$point;
            $binarylog->direction = $direction;
            $binarylog->type = $type;
            $binarylog->usd_value = $usd_value;
            $binarylog->save();
            if ($data->person) {
                $flashOutCalc = DB::select("SELECT COALESCE(SUM(usd_amount),0) as  usd_amount FROM `comissions` WHERE user_id=".$data->person." AND type='BINARY' AND created_at >= now() - INTERVAL 1 DAY");

                if ($flashOutCalc[0]->usd_amount >= 1000 ) {
                    continue;
                }
            }


            $twocheck = User::where('upline_id', (integer)$data->person)->where('payment', 1)->get();

            $twocheck = count($twocheck);
            $idsi = (integer)$data->person;

            $comission = Binarypoint::where('user_id', (integer)$data->person)->first();

            $point_binary_usd = $usd_value;
            if (!$comission) {
                $comission = new Binarypoint;
                $comission->user_id = (integer)$data->person;
                if ($direction == 'L') {
                    $comission->left_point = $point;
                    $comission->left_point_total = $point;
                    $comission->left_point_usd = $point_binary_usd;
                    $comission->left_point_total_usd = $point_binary_usd;
                    $comission->right_point_usd = 0.0;
                    $comission->right_point = 0.0;
                    $comission->right_point_total = 0.0;
                    $comission->right_point_total_usd = 0.0;

                } else {
                    $comission->right_point = $point;
                    $comission->right_point_total = $point;
                    $comission->right_point_usd = $point_binary_usd;
                    $comission->right_point_total_usd = $point_binary_usd;
                    $comission->left_point_usd = 0.0;
                    $comission->left_point = 0.0;
                    $comission->left_point_total = 0.0;
                    $comission->left_point_total_usd = 0.0;

                }
                $comission->total_point_usd += $point_binary_usd;
                $comission->total_point += $point;
                $comission->save();

            } else {
                if ($direction == 'L') {
                    $comission->left_point = $point + $comission->left_point;
                    $comission->left_point_total = $point + $comission->left_point_total;
                    $comission->left_point_usd += $point_binary_usd;
                    $comission->left_point_total_usd += $point_binary_usd;

                } else {
                    $comission->right_point = $point + $comission->right_point;
                    $comission->right_point_total = $point + $comission->right_point_total;
                    $comission->right_point_usd += $point_binary_usd;
                    $comission->right_point_total_usd += $point_binary_usd;
                }
                $comission->total_point += $point;

                $comission->total_point_usd += $point_binary_usd;
                $comission->save();

            }

            $prim_usd = $usd_value;
            $left_point = $comission->left_point;
            $right_point = $comission->right_point;
            $left_point_usd = $comission->left_point_usd;
            $right_point_usd = $comission->right_point_usd;
            if ($twocheck > 1) {
                if ($left_point_usd <= $right_point_usd) {
                    $prim = $left_point;
                    $prim_usd = $left_point_usd;
                } else {
                    $prim = $right_point;
                    $prim_usd = $right_point_usd;
                }
                if ($left_point_usd >= $right_point_usd && ($right_point_usd > 0)) {

                    $point_binary_usd = (float)$prim_usd;
                    $point_binary_btc = (float)$prim;
                    $comission->right_point -= $prim;
                    $comission->left_point -= $prim;
                    $comission->right_point_usd -= $prim_usd;
                    $comission->left_point_usd -= $prim_usd;

                    $comission->save();

                    $prim_tot += self::add_comission_binary((integer)$data->person, 'R', $point_binary_btc, $point_binary_usd, $id, $depth);



                } else if ($left_point_usd <= $right_point_usd && ($left_point_usd > 0)) {
                    $point_binary_usd = (float)$prim_usd;
                    $point_binary_btc = (float)$prim;
                    $comission->right_point -= $prim;
                    $comission->left_point -= $prim;
                    $comission->right_point_usd -= $prim_usd;
                    $comission->left_point_usd -= $prim_usd;
                    $comission->save();

                    $prim_tot += self::add_comission_binary((integer)$data->person, 'L', $point_binary_btc, $point_binary_usd, $id, $depth);


                }

            }


            $usrData = User::where('id', (integer)$data->person)->first();
            if (empty($usrData)) continue;
            $direction = $usrData->direction;

        }
        return $prim_tot;
    }

    public static function add_comission_binary($user_id, $direction, $amount, $amount_usd, $from_id, $depth)
    {
        $bugun = trim(self::strftime('%e'));
        $yil = date('Y');
        $yilinilk = ($yil . '-01-01');
        $tarih1 = strtotime($yilinilk);
        $bug = date('Y-m-d');
        $tarih2 = strtotime($bug);
        $gunfarki = ($tarih2 - $tarih1) / 86400;

        $kacay = date('n');
        $buay = trim(self::strftime($kacay));

        $buhafta = round($gunfarki / 7) + 0;
        $today_date = date('Y-m-d');
        $currentWeek = ceil((date("d", strtotime($today_date)) - date("w", strtotime($today_date)) - 1) / 7) + 1;

        $usd = $amount_usd * 10 / 100;

        $cms = new Comission;
        $cms->user_id = $user_id;
        $cms->from_id = (int)$from_id;
        $cms->usd_amount = $usd;
        $cms->type = 'BINARY';
        $cms->depth = $depth;
        $cms->rate = 10;
        $cms->month = (integer)$buay;
        $cms->year = (integer)$yil;
        $cms->week = (integer)$buhafta;
        $cms->day = $today_date;
        $cms->status = 'available';
        $cms->save();

        return $cms->amount;

    }

    public static function calcCareerAllUsers(){
        $users = DB::select("SELECT * FROM users WHERE payment = 1 AND active = 1 AND (binary_id != 0 OR id = 1)");
        foreach ($users as $user) {
            self::calcUserCareer($user->id);
        }
        return 1;
    }
    public static function calcUserCareer($user_id){
        $current_user = User::find($user_id);
        $users = User::where('binary_id',$user_id)->get();
        $left_user_info = ["career_with_ref" => 0, "career_count" => 0];
        $right_user_info = ["career_with_ref" => 0, "career_count" => 0];
        if ($users) {
            foreach ($users as $key => $user) {
                if ($user->direction == "L") {
                    $left_user_info = self::findTotalCareerMyTeam($user_id,$user->id);

                    if ($user->upline_id == $user_id) {
                        $left_user_info["career_with_ref"] += 1;
                    }
                    if ($user->career > 0) {
                        $left_user_info["career_count"] += 1;
                    }

                }elseif ($user->direction == "R") {
                    $right_user_info = self::findTotalCareerMyTeam($user_id,$user->id);

                    if ($user->upline_id == $user_id) {
                        $right_user_info["career_with_ref"] += 1;
                    }
                    if ($user->career > 0) {
                        $right_user_info["career_count"] += 1;
                    }

                }
            }

        }

        $win_career = self::calcCareer($current_user->career, $left_user_info["career_with_ref"], $left_user_info["career_count"], $right_user_info["career_with_ref"], $right_user_info["career_count"]);
        if ($win_career > $current_user->career) {
            RankLog::create([
                'user_id' => $current_user->id,
                'old_career' => $current_user->career,
                'new_career' => $win_career,
                'created_at' => date('Y-m-d h:i:s'),
            ]);
            $current_user->career = $win_career;
            $current_user->save();
        }

    }
    public static function findTotalCareerMyTeam($user_id, $sub_user_id, $career_info = []){
        if (!isset($career_info["career_with_ref"])) {
            $career_info["career_with_ref"] = 0;
        }
        if (!isset($career_info["career_count"])) {
            $career_info["career_count"] = 0;
        }
        $users = User::where('binary_id',$sub_user_id)->get();
        if (!$users) {
            return $career_info;
        }
        foreach ($users as $key => $user) {
            if ($user->upline_id == $user_id) {
                $career_info["career_with_ref"] += 1;
            }
            if ($user->career > 0) {
                $career_info["career_count"] += 1;
            }
            $career_info = self::findTotalCareerMyTeam($user_id, $user->id,$career_info);
            /*
            $sub_users = User::where('binary_id', $user->id)->get();
            if ($sub_users) {
                foreach ($sub_users as $key => $sub_user) {
                   $career_info = self::findTotalCareerMyTeam($user_id, $sub_user->id,$career_info);
                }

            }
            */
        }
        return $career_info;
    }
    public static function calcCareer($user_career,$left_career_with_ref,$left_career_count,$right_career_with_ref,$right_career_count){
        if ($user_career == 0) {
            if ($left_career_with_ref > 0 && $right_career_with_ref > 0) {
                return 1;
            }
        }elseif ($user_career == 1) {
            if ($left_career_count >= 3 && $right_career_count > 3) {
                return 2;
            }
        }elseif ($user_career == 2) {
            if ($left_career_count >= 8 && $right_career_count > 8) {
                return 3;
            }
        }elseif ($user_career >= 3) {
            return 3;
        }
        return 0;
    }

    public static function calcMatchingAllUsers(){
        $users = User::where('active',1)->where('payment',1)->get();
        foreach ($users as $user) {
            if ($user->career == 0 || $user->career == null) {
                continue;
            }
            self::matching($user->id);
        }
    }
    public static function matching($user_id){
        $start = Carbon::yesterday()->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        $day = Carbon::yesterday()->day;
        $week = Carbon::yesterday()->week;
        $month = Carbon::yesterday()->month;
        $year = Carbon::yesterday()->year;
        $current_user = User::find($user_id);
        //left user
        $binary_left = User::where('binary_id',$user_id)->where('direction','L')->first();
        if ($binary_left) {
            $binary_left->depth = 0;
            $binary_left->usd_giro = Payment::where('user_id',$binary_left->id)
                ->where('is_pay',1)->whereBetween('created_at', [$start, $end])->sum('usd_amount');

            $binary_left->comission_giro = Comission::where('user_id',$binary_left->id)->where('type','BINARY')
                ->whereBetween('created_at', [$start, $end])->sum('usd_amount');
            //right user
            $binary_right = User::where('binary_id',$user_id)->where('direction','R')->first();
            if($binary_right){
                $binary_right->depth = 0;
                $binary_right->usd_giro = Payment::where('user_id',$binary_right->id)
                    ->where('is_pay',1)->whereBetween('created_at', [$start, $end])->sum('usd_amount');

                $binary_right->comission_giro = Comission::where('user_id',$binary_right->id)->where('type','BINARY')
                    ->whereBetween('created_at', [$start, $end])->sum('usd_amount');

                $binary_left_users = self::myTeamBinaryCalc($binary_left->id);
                array_push($binary_left_users,$binary_left);
                //dd($binary_left_users);

                $binary_right_users = self::myTeamBinaryCalc($binary_right->id);
                array_push($binary_right_users,$binary_right);
                //dd($binary_right_users);
                $leftTotalGiro = self::totalGiro($binary_left_users);

                $leftTotalGiro += $binary_left->usd_giro;
                //dd($leftTotalGiro);

                $rightTotalGiro = self::totalGiro($binary_right_users);
                $rightTotalGiro += $binary_right->usd_giro;

                if ($leftTotalGiro < $rightTotalGiro) {
                    $rate_info = self::matching_rate_info($current_user->career);
                    //dd($rate_info);
                    if($rate_info['rate'] != 0){
                        $users = self::myteamcalcformatching($user_id,$rate_info['depth']);
                        //dd($users);

                        foreach ($users as $user) {
                            if(!isset($rate_info['rate']) || $user->comission_giro == 0){
                                continue;
                            }
                            $rate = $rate_info['rate'];

                            $usd_amount = $user->comission_giro*$rate/100;
                            Comission::create([
                                'user_id' => $user_id,
                                'from_id' => $user->id,
                                'usd_amount' => $usd_amount,
                                'type' => 'MATCHING',
                                'depth' => $user->depth,
                                'month' => $month,
                                'year' => $year,
                                'week' => $week,
                                'day' => $day,
                                'rate' => $rate,
                                'status' => 'available'

                            ]);
                        }
                    }
                }
                else{

                    $rate_info = self::matching_rate_info($current_user->career);
                    //dd($rate_info);
                    if($rate_info['rate'] != 0){
                        $users = self::myteamcalcformatching($user_id,$rate_info['depth']);
                        //dd($users);
                        foreach ($users as $user) {
                            if(!isset($rate_info['rate']) || $user->comission_giro == 0){
                                continue;
                            }
                            $rate = $rate_info['rate'];
                            $usd_amount = $user->comission_giro*$rate/100;
                            Comission::create([
                                'user_id' => $user_id,
                                'from_id' => $user->id,
                                'usd_amount' => $usd_amount,
                                'type' => 'MATCHING',
                                'depth' => $user->depth,
                                'month' => $month,
                                'year' => $year,
                                'week' => $week,
                                'day' => $day,
                                'rate' => $rate,
                                'status' => 'available'

                            ]);
                        }
                    }
                }
            }
        }
    }
    public static function myteamcalcformatching($firstID,$limit_depth,$depth = 0,$children = []){
        $start = Carbon::yesterday()->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        $firstLineUsers = User::where('binary_id',$firstID)->where('active',1)->where('payment',1)->get();
        if($firstLineUsers){
            foreach ($firstLineUsers as $child) {
                if ($depth > $limit_depth) {
                    break;
                }
                $child->depth = $depth;
                $child->comission_giro = Comission::where('user_id',$child->id)->where('type','BINARY')
                    ->whereBetween('created_at', [$start, $end])->sum('usd_amount');

                array_push($children,$child);
                $children = self::myteamcalcformatching($child->id,$limit_depth,$depth+1, $children);
            }

        }
        return $children;
    }
    public static function myTeamBinaryCalc($firstID,$depth = 1,$children = []){
        $start = Carbon::yesterday()->startOfDay();
        $end = Carbon::yesterday()->endOfDay();

        $firstLineUsers = User::where('binary_id',$firstID)->where('active',1)->get();
        if($firstLineUsers){
            foreach ($firstLineUsers as $child) {
                $child->usd_giro = Payment::where('user_id',$child->id)->where('is_pay',1)
                    ->whereBetween('created_at', [$start, $end])->sum('usd_amount');

                $child->comission_giro = Comission::where('user_id',$child->id)->where('type','BINARY')
                    ->whereBetween('created_at', [$start, $end])->sum('usd_amount');

                $child->depth = $depth;
                array_push($children,$child);
                $children = self::myTeamBinaryCalc($child->id,$depth+1, $children);
            }

        }
        return $children;
    }
    public static function binaryCount($firstID,$depth = 1,$children = []){
        $firstLineUsers = User::where('binary_id',$firstID)->where('active',1)->get();
        if($firstLineUsers){
            foreach ($firstLineUsers as $child) {
                $child->depth = $depth;
                array_push($children,$child);
                $children = self::myTeamBinaryCalc($child->id,$depth+1, $children);
            }

        }
        return $children;
    }
    public static function totalGiro($users){
        $totalGiro = 0;
        foreach ($users as $user) {
            $totalGiro += $user->usd_giro;
        }
        return $totalGiro;
    }
    public static function matching_rate_info($career){
        if ($career == 1) {

            return array('rate' => 10, 'depth' => 1);

        }elseif ($career == 2) {

            return array('rate' => 10, 'depth' => 3);

        }elseif ($career >= 3) {

            return array('rate' => 10, 'depth' => 6);
        }else{
            return array('rate' => 0);
        }
    }

    public static function strftime(string $format, $timestamp = null, $locale = null)
    {
        if (null === $timestamp) {
            $timestamp = new \DateTime;
        }
        elseif (is_numeric($timestamp)) {
            $timestamp = date_create('@' . $timestamp);

            if ($timestamp) {
                $timestamp->setTimezone(new \DateTimezone(date_default_timezone_get()));
            }
        }
        elseif (is_string($timestamp)) {
            $timestamp = date_create($timestamp);
        }

        if (!($timestamp instanceof \DateTimeInterface)) {
            throw new \InvalidArgumentException('$timestamp argument is neither a valid UNIX timestamp, a valid date-time string or a DateTime object.');
        }

        $locale = substr((string) $locale, 0, 5);

        $intl_formats = [
            '%a' => 'EEE',	// An abbreviated textual representation of the day	Sun through Sat
            '%A' => 'EEEE',	// A full textual representation of the day	Sunday through Saturday
            '%b' => 'MMM',	// Abbreviated month name, based on the locale	Jan through Dec
            '%B' => 'MMMM',	// Full month name, based on the locale	January through December
            '%h' => 'MMM',	// Abbreviated month name, based on the locale (an alias of %b)	Jan through Dec
        ];

        $intl_formatter = function (\DateTimeInterface $timestamp, string $format) use ($intl_formats, $locale) {
            $tz = $timestamp->getTimezone();
            $date_type = \IntlDateFormatter::FULL;
            $time_type = \IntlDateFormatter::FULL;
            $pattern = '';

            // %c = Preferred date and time stamp based on locale
            // Example: Tue Feb 5 00:45:10 2009 for February 5, 2009 at 12:45:10 AM
            if ($format == '%c') {
                $date_type = \IntlDateFormatter::LONG;
                $time_type = \IntlDateFormatter::SHORT;
            }
            // %x = Preferred date representation based on locale, without the time
            // Example: 02/05/09 for February 5, 2009
            elseif ($format == '%x') {
                $date_type = \IntlDateFormatter::SHORT;
                $time_type = \IntlDateFormatter::NONE;
            }
            // Localized time format
            elseif ($format == '%X') {
                $date_type = \IntlDateFormatter::NONE;
                $time_type = \IntlDateFormatter::MEDIUM;
            }
            else {
                $pattern = $intl_formats[$format];
            }

            return (new \IntlDateFormatter($locale, $date_type, $time_type, $tz, null, $pattern))->format($timestamp);
        };

        // Same order as https://www.php.net/manual/en/function.strftime.php
        $translation_table = [
            // Day
            '%a' => $intl_formatter,
            '%A' => $intl_formatter,
            '%d' => 'd',
            '%e' => function ($timestamp) {
                return sprintf('% 2u', $timestamp->format('j'));
            },
            '%j' => function ($timestamp) {
                // Day number in year, 001 to 366
                return sprintf('%03d', $timestamp->format('z')+1);
            },
            '%u' => 'N',
            '%w' => 'w',

            // Week
            '%U' => function ($timestamp) {
                // Number of weeks between date and first Sunday of year
                $day = new \DateTime(sprintf('%d-01 Sunday', $timestamp->format('Y')));
                return sprintf('%02u', 1 + ($timestamp->format('z') - $day->format('z')) / 7);
            },
            '%V' => 'W',
            '%W' => function ($timestamp) {
                // Number of weeks between date and first Monday of year
                $day = new \DateTime(sprintf('%d-01 Monday', $timestamp->format('Y')));
                return sprintf('%02u', 1 + ($timestamp->format('z') - $day->format('z')) / 7);
            },

            // Month
            '%b' => $intl_formatter,
            '%B' => $intl_formatter,
            '%h' => $intl_formatter,
            '%m' => 'm',

            // Year
            '%C' => function ($timestamp) {
                // Century (-1): 19 for 20th century
                return floor($timestamp->format('Y') / 100);
            },
            '%g' => function ($timestamp) {
                return substr($timestamp->format('o'), -2);
            },
            '%G' => 'o',
            '%y' => 'y',
            '%Y' => 'Y',

            // Time
            '%H' => 'H',
            '%k' => function ($timestamp) {
                return sprintf('% 2u', $timestamp->format('G'));
            },
            '%I' => 'h',
            '%l' => function ($timestamp) {
                return sprintf('% 2u', $timestamp->format('g'));
            },
            '%M' => 'i',
            '%p' => 'A', // AM PM (this is reversed on purpose!)
            '%P' => 'a', // am pm
            '%r' => 'h:i:s A', // %I:%M:%S %p
            '%R' => 'H:i', // %H:%M
            '%S' => 's',
            '%T' => 'H:i:s', // %H:%M:%S
            '%X' => $intl_formatter, // Preferred time representation based on locale, without the date

            // Timezone
            '%z' => 'O',
            '%Z' => 'T',

            // Time and Date Stamps
            '%c' => $intl_formatter,
            '%D' => 'm/d/Y',
            '%F' => 'Y-m-d',
            '%s' => 'U',
            '%x' => $intl_formatter,
        ];

        $out = preg_replace_callback('/(?<!%)(%[a-zA-Z])/', function ($match) use ($translation_table, $timestamp) {
            if ($match[1] == '%n') {
                return "\n";
            }
            elseif ($match[1] == '%t') {
                return "\t";
            }

            if (!isset($translation_table[$match[1]])) {
                throw new \InvalidArgumentException(sprintf('Format "%s" is unknown in time format', $match[1]));
            }

            $replace = $translation_table[$match[1]];

            if (is_string($replace)) {
                return $timestamp->format($replace);
            }
            else {
                return $replace($timestamp, $match[1]);
            }
        }, $format);

        $out = str_replace('%%', '%', $out);
        return $out;
    }
}
