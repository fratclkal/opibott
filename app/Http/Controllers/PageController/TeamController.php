<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Calc;
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

class TeamController extends Controller
{

    public function ajax_info(Request $request)
    {
        $fWeecode = $request->weecode;
        $userCareer = '';

        $usersL = User::where('sponsor_id', '=', $fWeecode)->first();


        $userbinary = User::where('binary_id', '=', $usersL->id)->get();

        $points = Binarypoint::where('user_id', $usersL->id)->first();


        $left_point = 0;
        $right_point = 0;
        $left_point_sum = 0;
        $right_point_sum = 0;
        foreach ($userbinary as $binary) {

            if ($binary->direction == "L") {
                $left_point = DB::select('call getCounBinary(?,9999,"L")', array($binary->binary_id));
                $left_point = $left_point[0]->count;
                $left_point_sum += $left_point;
            } else if ($binary->direction == "R") {
                $right_point = DB::select('call getCounBinary(?,9999,"R")', array($binary->binary_id));
                $right_point = $right_point[0]->count;
                $right_point_sum += $right_point;
            }


        }


        if (!isset($points)) {
            $useable_left_point = 0;
            $useable_right_point = 0;
            $useable_left_total_point = 0;
            $useable_right_total_point = 0;
        } else {
                $useable_left_point = $points->left_point_usd;
                $useable_right_point = $points->right_point_usd;
                $useable_left_total_point = $points->left_point_total_usd;
                $useable_right_total_point = $points->right_point_total_usd;

        }

        echo '
          <div class="tooltip_profile_detaile">
              <table class="table" style="width:100%">
              <thead>
                <tr class="headtable">
                  <th>'.'Bilgi'.'</th>
                  <th>'.'Sol'.'</th>
                  <th>'.'Sağ'.'</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><span class="icon-user"></span>'.'Ekip Sayısı'.'</td>
                  <td>' . $left_point_sum . '</td>
                  <td>' . $right_point_sum . '</td>
                </tr>
                <tr>
                  <td><span class="icon-user"></span> '.'Mevcut'.' $</td>
                  <td>' . number_format($useable_left_point , 2) . '</td>
                  <td>' . number_format($useable_right_point , 2) . '</td>
                </tr>
                <tr>
                  <td><span class="icon-user"></span> '.'Toplam'.' $</td>
                  <td>' . number_format($useable_left_total_point, 2) . '</td>
                  <td>' . number_format($useable_right_total_point , 2) . '</td>
                </tr>
                <tr>
                  <td colspan="2"><span class="icon-user"></span> '.'Paket Tutarı'.'</td>
                  <td>' . number_format(Payment::where('user_id', $usersL->id)->where('is_pay','1')->sum('usd_amount'),2) . ' $</td>
                </tr>

                <tr>
                  <td colspan="3" ><div class="treeButton" onclick="boxClose()" style="color: #000"><span class="icon-minus"></span> '.'Kapat'.'</div></td>
                </tr>
              </tbody>
            </table>
          </div>
  ';
    }

    public static function createPeople($position, $width, $username, $link)
    {

        return '
            <span class="binary-hr-line binar-hr-line-' . $position . ' binary-hr-line-width-' . $width . '"></span>
                <div class="node-item-2-child-left ">
                    <div class="binary-node-single-item user-block user-5">
                        <div class="images_wrapper"><a href="' . $link . '"><img  style="border-radius: 50%;" class="profile-rounded-image-small" src="/assets/add_tr.png"  alt="Add new member" title="Add new member"></a></div>
                        <span class="wrap_content"><a class="hide-button" href="' . $link . '">' . $username . '</a></span>
                    </div>
                </div>
            ';
    }

    public static function depthFind($usersData, $firstID, $lastID, $depthnumber = 1)
    {
        //echo $usersData[$lastID]->parent_id." == ".$firstID." <br>";
        if (isset($usersData[$lastID])) {
            if ($usersData[$lastID]->binary_id == $firstID) {
                $sonuc = $depthnumber;
            } else {
                $depthnumber++;
                $newID = $usersData[$lastID]->binary_id;
                $sonuc = self::depthFind($usersData, $firstID, $newID, $depthnumber);
            }
        } else {
            $sonuc = 0;
        }
        if (isset($sonuc)) {
            return $sonuc;
        }

    }

    public static function Weecode($teamList, $userID)
    {


        Global $sonuc;
        $sonuc[$userID] = $userID;
        if (isset($teamList[$userID]) AND !empty($teamList[$userID])) {
            foreach ($teamList[$userID] as $ID) {
                self::Weecode($teamList, $ID);
            }
        }
        return $sonuc;
    }

    public static function findTeam($weeCode, $searchWeeCode, $users = null)
    {
        if (empty($users)) {
            $users = DB::select('SELECT * FROM users WHERE payment = 1 AND active = 1 AND binary_id != 0');
            $users[count($users)] = User::where('sponsor_id',$weeCode)->first();
        }
        if ($users) {

            foreach ($users as $userDetail) {
                if ($userDetail->payment > 0) {
                    $newList[$userDetail->sponsor_id] = $userDetail->id;
                    $newListName[$userDetail->id] = $userDetail->name;
                }
            }

            $allTree = array();
            foreach ($users as $userDetail) {

                if ($userDetail->direction == "L") {
                    $position = "left";
                } else if ($userDetail->direction == "R") {
                    $position = "right";
                }else{
                    continue;
                }

                if (!isset($allTree[$userDetail->binary_id])) {
                    $allTree[$userDetail->binary_id][$position] = $userDetail->id;
                } elseif (Count($allTree[$userDetail->binary_id]) < 2) {
                    $allTree[$userDetail->binary_id][$position] = $userDetail->id;
                }

            }

            $tumEkip = self::Weecode($allTree, $newList[$weeCode]);


            if (isset($tumEkip) AND !empty($tumEkip)) {
                unset($newList[$weeCode]);
            }


            if (isset($newList[$searchWeeCode]) AND isset($tumEkip[$newList[$searchWeeCode]])) {
                return 1;
            }

        }
        return 0;
    }
    public function getUserSettlementTree(Request $request){
        if ($request->type == 'name') {
            $user = User::where('name',$request->userinfo)->first();
            if ($user) {
                return redirect('/binary-tree/'.$user->sponsor_id);
            }else{
                return back()->with('error','Hata 1');
            }
        }elseif($request->type == 'username'){
            $user = User::where('user_name',$request->userinfo)->first();
            if ($user) {
                return redirect('/binary-tree/'.$user->sponsor_id);
            }else{
                return back()->with('error','Hata 2');
            }
        }elseif($request->type == 'email'){
            $user = User::where('email',$request->userinfo)->first();
            if ($user) {
                return redirect('/binary-tree/'.$user->sponsor_id);
            }else{
                return back()->with('error','Hata 3');
            }
        }
    }
    public function get_index(Request $request = null, $searchWeeCode = null, $addTreeWeeCode = null)
    {

        // direction ve binary yoksa girme
        if(Auth::user()->direction == '0' || Auth::user()->binary_id == 0){
            //return redirect()->route('homePage')->with('binaryno', 'messagebinary');
           //return back();
        }

        $users = User::where('payment', 1)->where('active', 1)->get();
        $countries = Country::all();
        if ($countries->isNotEmpty()) {
            foreach ($countries as $countriesDetail) {
                $countryList[$countriesDetail->id] = $countriesDetail;
            }
        } else {
            $countryList = 0;
        }


        if ($users) {
            foreach ($users as $userDetail) {
                $weecodeToID[$userDetail->sponsor_id] = $userDetail->id;
                $userDetails[$userDetail->sponsor_id] = $userDetail;
                $usersData[$userDetail->id] = $userDetail;
            }


            $allTree = array();

            foreach ($users as $userDetail) {
                if ($userDetail->direction == "L") {
                    $position = "left";
                } else if ($userDetail->direction == "R") {
                    $position = "right";
                }else{
                    continue;
                }


                if (!isset($allTree[$userDetail->binary_id])) {
                    $allTree[$userDetail->binary_id][$position] = $userDetail->id;
                } elseif (Count($allTree[$userDetail->binary_id]) < 2) {
                    $allTree[$userDetail->binary_id][$position] = $userDetail->id;
                }

            }


        }


        $weeCode =  $addTreeWeeCode ? $addTreeWeeCode : (integer)Auth::user()->sponsor_id;
        //dd($weeCode);
        if (empty($searchWeeCode) OR $searchWeeCode == $weeCode) {
            $error = 0;
            $errortype = 0;

            $teamTreeCode = $weecodeToID[$weeCode];
            $searchWeeCodeInput = $weeCode;

        } else {

            $searchWeeCodeInput = $searchWeeCode;
            $teamTreeCode = $weecodeToID[$weeCode];

            $teamkontrol = self::findTeam($weeCode, $searchWeeCode);
            if (empty($teamkontrol)) {
                $error = 1;
                $errortype = 2;
            } else {
                $error = 0;
                $errortype = 0;
                $teamTreeCode = $weecodeToID[$searchWeeCode];

            }
        }

        $allCareerList = 0;



       // $addTreeWeeCode = $searchWeeCodeInput;
        return view('binarytree')
            ->with('error', $error)
            ->with('errortype', $errortype)
            ->with('teamTreeCode', $teamTreeCode)
            ->with('usersData', $usersData)
            ->with('allTree', $allTree)
            ->with('countryList', $countryList)
            ->with('searchWeeCodeInput', $searchWeeCodeInput)
            ->with('searchWeeCode', $searchWeeCode)
            ->with('addTreeWeeCode', $addTreeWeeCode)
            ->with('allCareerList', $allCareerList)
            ->with('users', $users);
    }


    public static function findTeamAll($weeCode, $searchWeeCode, $users = null)
    {


        if (empty($users)) {
            $users = User::where('payment', '>', 0)->where('active', 1)->get();
        }

        if ($users) {

            foreach ($users as $userDetail) {
                if ($userDetail->payment > 0 AND $userDetail->active == 1) {
                    $newList[$userDetail->upline_id] = $userDetail->id;
                    $newListID[$userDetail->id] = $userDetail->id;
                    $newListIDTree[$userDetail->upline_id][] = $userDetail->id;
                    $newListName[$userDetail->id] = $userDetail->name;
                }
            }


            $allTree = array();
            foreach ($users as $userDetail) {
                if ($userDetail->payment > 1) {
                    if ($userDetail->direction == 1) {
                        $position = "L";
                    } else {
                        $position = "R";
                    }

                    if (!isset($allTree[$userDetail->binary_id])) {
                        $allTree[$userDetail->binary_id][$position] = $userDetail->id;
                    } elseif (Count($allTree[$userDetail->binary_id]) < 2) {
                        $allTree[$userDetail->binary_id][$position] = $userDetail->id;
                    }
                }
            }

            $allTeam = self::Weecode($allTree, $newList[$weeCode]);

            if (isset($allTeam) AND !empty($allTeam)) {


                foreach ($allTeam as $allTeamData) {
                    if (isset($newListIDTree[$allTeamData])) {
                        foreach ($newListIDTree[$allTeamData] as $dataDetail) {
                            $allTeam[$dataDetail] = $dataDetail;
                        }
                    }
                }
                unset($newList[$weeCode]);
            }

            if (isset($newList[$searchWeeCode]) AND isset($allTeam[$newList[$searchWeeCode]])) {
                return 1;
            }
        }
        return 0;
    }

    public static function allUserList($column = null)
    {

        $userControl = User::all();

        if (empty($column)) {
            foreach ($userControl as $controlData) {
                $userList[$controlData->id] = $controlData;
            }
            return $userList;
        } elseif (!empty($column)) {
            foreach ($userControl as $controlData) {
                $userList[$controlData->$column] = $controlData;
            }
            return $userList;
        }
    }


    public static function positionControl($allUsers, $controlUser, $positionType)
    {
        $controlUserID = $allUsers[$controlUser]->id;

        if (!empty($allUsers) AND isset($allUsers[$controlUser]) AND !empty($positionType) AND !empty($controlUser)) {
            foreach ($allUsers as $userControlData) {
                if ($userControlData->payment > 0 AND $userControlData->active == 1) {
                    $newList[$userControlData->binary_id][$userControlData->direction] = "L"; // Left 1
                }
            }

            if (isset($newList[$controlUserID][$positionType])) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }

    public static function userAccountNotAccess($user_id){
        return 1;
    }
    public static function checkOutLine($user, $position){
        $binary_id = $user->binary_id;
        if ($position != $user->direction && $user->direction != null) {
            return 0;
        }
        $up_user = User::find($binary_id);
        if ($up_user) {
            self::checkOutLine($up_user, $position);
        }
        return 1;
    }
    public function SettlementNewRegister($newUserCode,$parentID, $position)
    {
        // return 'Parent Id: '.$parentID." NewUser:".$newUserCode." pos:".$position;
        $ref_user = User::where('sponsor_id', $parentID)->first();
        $current_user = User::where('sponsor_id', $newUserCode)->first();
        if ($ref_user && $current_user) {
            if ($ref_user->id != Auth::user()->id) {
                $new_position = $position == 2 ? 'R':'L';
                $check = self::checkOutLine($ref_user, $new_position);
                if ($check == 0) {
                    return redirect()->back()->with('error', 'İç hattınıza ekleme yapamazsınız!');
                }

            }
        }
        if($newUserCode == $parentID){
            return back();
        }

        $isAccess = self::userAccountNotAccess($parentID);
        if ($isAccess == 0) {
            return back()->with('error', '%100 Paket seçiminizden ötürü işlem gerçekleştirilemiyor.');
        }
        $binary_id = User::where('sponsor_id', $parentID)->first()->id;


        $direction_check = ($position == 1) ? 'L' : (($position == 2) ? 'R' : null);
        $check = User::where('binary_id', $binary_id)->where('direction', $direction_check)->where('active', 0)->get();
        if (count($check) > 0) {
            foreach ($check as $x) {
                $userr = User::find($x->id);
                $userr->binary_id = 0;
                $userr->direction = '0';
                $userr->save();
            }
        }


        $position = ($position == 1) ? 'L' : (($position == 2) ? 'R' : null);
        $update = User::where("sponsor_id", $newUserCode)->first();
        /// Degisiklik yapildi 01.03.21
        if($update->id == $binary_id){
            return back();
        }

        $update->binary_id = $binary_id;
        $update->direction = $position;

        if ($update->save()) {
            Calc::send_payment_confirmation_binary($update->id);

            //dispatch(new \App\Jobs\BinaryTest($update->id));
            return redirect()->route('SettlementTreeIndex');
        } else {
            return back();
        }

    }

    public static function createTree($usersData, $allTree, $userID, $firstUserID, $countryList, $addTreeWeeCode, $allCareerList,$searchWeeCode, $depth = 0)
    {

         //dd($addTreeWeeCode.' : '. $searchWeeCode);

        $rootLink = request()->getSchemeAndHttpHost() . "/" . RequestNew::segment(1) . "/";


        if (!empty($addTreeWeeCode) && !empty($searchWeeCode)) {
            /*
             * Buraya girdiginde 1 veriyor linki buda hata
             *Ayyub hajiyev yerlesdirme bekliyor
             * */
            //dd($searchWeeCode);
            $buttonName = 'Yerleştir';//'Buraya Kaydet';//buraya kaydet
            $buttonLink['left'] = '/binary-tree-register/' . $searchWeeCode. '/' . $usersData[$userID]->sponsor_id . '/1';
            $buttonLink['right'] = '/binary-tree-register/' . $searchWeeCode. '/' . $usersData[$userID]->sponsor_id . '/2';
            $buttonPeople = route("SettlementTreeIndex") . '/' . $searchWeeCode . '/' . $usersData[$userID]->sponsor_id;

        } else {

            $buttonName = 'Boş';//' 'Новая Регистр.';//yeni kayıt
            $buttonLink['left'] = '';
            $buttonLink['right'] = '';
            $buttonPeople = route("SettlementTreeIndex") . '/' . $usersData[$userID]->sponsor_id;
        }


        if (isset($countryList[$usersData[$userID]->country_id])) {
            $countryName = $countryList[$usersData[$userID]->country_id]->name;
            $countryFlag = "/flags/" . strtolower($countryList[$usersData[$userID]->country_id]->sortname) . ".png";
        } else {
            $countryName = "-";
            $countryFlag = "/flags/none.png";
        }


        if (isset($allCareerList[$usersData[$userID]->uni_career_id])) {
            $badgesName = $allCareerList[$usersData[$userID]->uni_career_id]->name;
//            if (!empty($allCareerList[$usersData[$userID]->uni_career_id]->rozet)) {
//                $badgesImg = $allCareerList[$usersData[$userID]->uni_career_id]->rozet;
//            }
        } else {
            $badgesName = " - ";
        }

        if (!isset($badgesImg)) {
            $badgesImg = 'blank.png';
        }

        $width = "50";
        if ($depth == 1) {
            $width = "50";
        } elseif ($depth == 2) {
            $width = "25";
        } elseif ($depth == 3) {
            $width = "12";
        }


        if ($depth < 4) {
            $item = "root";
        } else {
            $item = "child";
        }

        $ss = " ";
        $finished = 0;
        $filter = 0;

        echo '<div data-id-node-user="'.$userID.'" class="first-item-node node-depth-'.$depth.' node-item-' . $item . '">
                    <div class="binary-node-single-item user-block user-0">
                        <div class="images_wrapper"><a href="javascript:;"><img style="filter: hue-rotate('.$filter.'deg);"
                                        class="node-depth-'.$depth.'-img profile-rounded-image-small tooltipwork weecodetreee"
                                        src="' . asset('/assets//img/faces/user.png') . '"
                                         alt="' . $usersData[$userID]->sponsor_id . '"
                                        title="' . $usersData[$userID]->sponsor_id . '" data-content="' . $usersData[$userID]->sponsor_id . '"></a></div>
                        <span class="wrap_content wrapinfo" ' . $ss . '>
                        <a '.($depth != 3 ? 'data-id-node-user="'.$userID.'" ' : '').' '.($depth != 3 ? 'data-id-node-user-my="'.$userID.'" ' : '').' class="node-depth-'.$depth.'-name node-name-link" href="' . $buttonPeople . '" style="word-break: break-all">' . $usersData[$userID]->user_name . '</a><a href="' . $buttonPeople . '" class="packagehover" ' . $ss . '></a></span>



                    </div>
                </div>

                ';


        if (isset($allTree[$userID]) AND !empty($allTree[$userID])) {
            if (self::depthFind($usersData, $firstUserID, $userID) < 4) {

                echo '<div data-depth="'.$depth.'" '.($depth != 3 ? 'data-id-node-parent-user="'.$userID.'" ' : '').' '.($depth != 3 ? 'data-id-node-user="'.$userID.'" ' : '').' class="parent-wrapper clearfix">';
            }
            foreach ($allTree[$userID] as $position => $TreeDetail) {
                $positionSelect = $position;
            }
            if (Count($allTree[$userID]) == 1) {

                if ($positionSelect == 'left') {
                    $newPosition = 'right';
                } else {
                    $newPosition = 'left';
                }
                $depth = self::depthFind($usersData, $firstUserID, $allTree[$userID][$positionSelect]);


                if ($depth < 4) {
                    echo '<div class="node-' . $newPosition . '-item binary-level-width-' . $width . '">';
                    echo self::createPeople($newPosition, '50', $buttonName, $buttonLink[$newPosition]);
                    echo '</div>';
                }
            }

            foreach ($allTree[$userID] as $position => $TreeDetail) {
                $depth = self::depthFind($usersData, $firstUserID, $TreeDetail);

                if ($depth < 4) {
                    echo '<div class="node-' . $position . '-item binary-level-width-' . $width . '">
                        <span class="binary-hr-line binar-hr-line-' . $position . ' binary-hr-line-width-' . $width . '"></span>';
                    self::createTree($usersData, $allTree, $TreeDetail, $firstUserID, $countryList, $addTreeWeeCode, $allCareerList,$searchWeeCode, $depth);
                    echo '</div>';
                }

            }

            echo '</div>';


        } else {
            if (self::depthFind($usersData, $firstUserID, $userID) < 3) {
                echo '<div class="parent-wrapper clearfix">';

                //Sol bölüm için
                echo '<div class="node-left-item binary-level-width-' . $width . '">';
                echo self::createPeople('left', '50', $buttonName, $buttonLink['left']);
                echo '</div>';

                //Sağ bölüm için
                echo '<div class="node-right-item binary-level-width-' . $width . '">';
                echo self::createPeople('right', '50', $buttonName, $buttonLink['right']);
                echo '</div>';

                echo '</div>';
            }


        }

    }
    public function getplacmentusers()
    {
        $user_id = Auth::user()->id;
        $getpassivemember = User::where("upline_id", (integer)$user_id)->where('binary_id', 0)->where('payment', 1)->get();
        return view('binarymember', compact('getpassivemember'));

    }
    public function get_index_team()
    {

        $package = "black";
        $userPaymentAmount = Payment::where('user_id',Auth::user()->id)->where('is_pay',1)->sum('usd_amount');

        $new[Auth::user()->sponsor_id][] = array(

                "fullname" => Auth::user()->name,
                "id" => Auth::user()->id,
                "tel" => Auth::user()->gsm,
                "email" => Auth::user()->email,
            );
        if (!isset($new)) {
            $new = null;
        }
        return view("myteam")->with("users", $new);
    }
    public function get_child($id)
    {

        $child = User::where("upline_id", $id)->where('active', 1)->where('payment', '<>', 0)->get();

        foreach ($child as $write) {
            $childPaymentAmount = Payment::where('user_id',$write->id)->where('is_pay',1)->sum('usd_amount');

            $new[$write->upline_id][] = array(

                "fullname" => $write->name,
                "id" => $write->id,
                "tel" => $write->gsm,
                "email" => $write->email,
            );

        }

        if (empty($new[$id])) {
            echo "";
        } else {
            echo "<ul class='submenu' style=\"list-style: none;\">";
            foreach ($new[$id] as $write) {

                if (Auth::user()->id) {
                    $messageperm = '<span class="teamspanright">  </span>';
                }


                $icon = null;
                //if (isset($new[$write['id']]) AND !empty($new[$write['id']])) {
                $icon = '<i class="si si si-plus"></i>';
                //}


                echo '<li style="display: flex"><a href="javascript:;" class="clicks" id=' . $write['id'] . '>' . $icon . '</a>' . $write['fullname'] . '


      ' . $messageperm . '
      </li>';
            }
            echo "</ul>";
        }

    }
    public function myteam(){
        $users = User::where('upline_id', Auth::user()->id)->get();
        View::share('users',$users);

        return view('myteam_list');
    }

}
