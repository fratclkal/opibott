<?php

use App\Http\Middleware\isLogout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Calc;
use App\Http\Controllers\LoginController\LoginController;
use App\Http\Controllers\PageController\HomeController;
use App\Http\Controllers\PageController\TeamController;
use App\Http\Controllers\PageController\PaymentController;
use App\Http\Controllers\PageController\ProfileController;
use App\Http\Controllers\PageController\WalletController;
use App\Http\Controllers\PageController\ComissionsController;
use App\Http\Controllers\PageController\UserBotController;
use App\Http\Controllers\AdminController\PaymentController as AdminPaymentController;
use App\Http\Controllers\AdminController\UserController as AdminUserController;
use App\Http\Controllers\AdminController\TransfersController as AdminTransfersController;
use App\Http\Controllers\AdminController\ComissionsController as AdminComissionsController;


Route::fallback(function () {

    return redirect(route('homePage'));

});

Route::get('/calcCareerAllUsers', [Calc::class,'calcCareerAllUsers'])->name('calcCareerAllUsers');
Route::get('/calcUserCareer/{user_id}', [Calc::class,'calcUserCareer'])->name('calcUserCareer');

Route::get('/calcMatchingAllUsers', [Calc::class,'calcMatchingAllUsers'])->name('calcMatchingAllUsers');
Route::get('/matching/{user_id}', [Calc::class,'matching'])->name('matching');

Route::get('/testPayment', [PaymentController::class,'testPayment'])->name('testPayment');
Route::post('/getCity', [LoginController::class,'getCity'])->name('getCity');

Route::middleware([isLogout::class])->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('/register/{ref_code?}', 'registerView')->name('registerView');
        Route::get('/login', 'login')->name('loginView');
        Route::post('/login', 'loginPost')->name('loginPost');
        Route::post('/register', 'registerPost')->name('registerPost');
        Route::get('/forgot_password', 'forgot_password')->name('forgot_password');
        Route::post('/forgot_password_post', 'forgot_password_post')->name('forgot_password_post');
        Route::get('/reset_password/{email}/{token}', 'reset_password')->name('reset_password');
        Route::post('/reset_password_post', 'reset_password_post')->name('reset_password_post');
    });

});

Route::middleware([isLogin::class])->group(function () {
    Route::middleware([isPayment::class])->group(function () {
        Route::controller(HomeController::class)->group(function () {
            Route::get('/', 'index')->name('homePage');
        });
    });
    Route::controller(LoginController::class)->group(function () {
        Route::get('/logout', 'logout')->name('logout');
    });
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/pricing/{borsa?}', 'pricing')->name('pricing');
        Route::get('/payment_await', 'payment_await')->name('payment_await');
        Route::get('/select_package/{package_id}/{borsa?}', 'select_package')->name('select_package');
        Route::get('/delete_package/{payment_id}', 'delete_package')->name('delete_package');
        Route::post('/pay_package', 'pay_package')->name('pay_package');

    });

    Route::controller(TeamController::class)->group(function () {
        Route::post('/treedata', 'ajax_info')->name('TreeData');
        Route::get('/binary-tree/{id?}/{parent?}','get_index')->name('SettlementTreeIndex');
        Route::get('/awaitingBinaryMember', 'getplacmentusers')->name('AwaitingSettlement');
        Route::get('sponsor_id', 'getSponsorId')->name('GetSponsorId');
        Route::get('/addNewMember/{sponsor_id?}/{leftright?}', 'addNewMemberIndex')->name('addNewMemberIndex');
        Route::post('/user-binary-tree/', 'getUserSettlementTree')->name('getUserSettlementTree');
        //Aktif-pasif kayitlar
        Route::get('/myteam', 'myteam')->name('myteam');
        Route::get('/team', 'get_index_team')->name('teamList');
        //Ekip kirilimi
        Route::get('/teamtree', 'teamTree')->name('teamTree');
        Route::get('/ekibimgetir/{id}', 'get_child')->name('get_child');
        Route::get('binary-tree-register/{newUserID}/{parentID}/{position}', 'SettlementNewRegister')->name('SettlementNewRegister');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile','profileIndex')->name('profileIndex');
        Route::post('/profile','profileEdit')->name('profileEdit');
    });

    Route::controller(WalletController::class)->group(function () {
        Route::get('/mywallets','myWallets')->name('myWallets');
        Route::post('/mywallets','myWalletsPost')->name('myWalletsPost');
        Route::get('/wallet','walletIndex')->name('WalletIndex');
        Route::get('/withdraw/confirmation/{withdraw_id}/{token}','withdrawConfirmation')->name('withdraw_mail_confirmation');
        Route::get('/withdraw/delete/{id}','withdrawDelete')->name('withdrawDelete');
        Route::post('/wallet/withdraw','withdraw')->name('withdrawWallet');
    });
    Route::controller(ComissionsController::class)->group(function () {
        Route::get('/comissions/details','index')->name('allComissions');
        Route::get('/comissions/details/{type}','comissions')->name('comissionsDetails');
        Route::get('/matching/details','matchingDetails')->name('matchingDetails');
    });

    Route::controller(UserBotController::class)->group(function () {
        Route::get('/user-bot-settings','index')->name('user_bot_settings');
        Route::post('/user-bot-settings','settings')->name('change_user_bot_settings');
    });


    //--------------------------------------ADMIN----------------------------------------------------------------------

    Route::controller(AdminPaymentController::class)->group(function () {
        Route::get('/payment_list', 'payment_list')->name('payment_list');
        Route::get('/accept_payment/{payment_id}', 'accept_payment')->name('acceptPayment');
        Route::get('/reject_payment/{payment_id}', 'reject_payment')->name('rejectPayment');
        Route::get('/delete_payment/{payment_id}', 'delete_payment')->name('delete_payment');
    });


    Route::controller(AdminUserController::class)->group(function () {
        Route::get('/users_list', 'user_list')->name('user_list');
        Route::get('/users_bot_list', 'user_bot_list')->name('user_bot_list');
        Route::post('/users_bot_delete', 'user_bot_delete')->name('user_bot_delete');

    });
    Route::controller(AdminTransfersController::class)->group(function () {
        Route::get('/transfer_list', 'transfer_list')->name('transfer_list');
        Route::get('/all_transfer_list', 'all_transfer_list')->name('all_transfer_list');
        Route::get('/transfer_reject/{id}', 'withdrawDelete')->name('transfer_reject');
        Route::get('/transfer_accept/{id}', 'withdrawAccept')->name('transfer_accept');

    });
    Route::controller(AdminComissionsController::class)->group(function () {
        Route::get('/users_balance','users_balance')->name('users_balance');
        Route::get('/users_comissions','index')->name('users_comissions');
        Route::get('/users_comissions/{user_id}/{type}','comissions')->name('users_comissions_details');
        Route::get('/total_turnover','total_turnover')->name('total_turnover');
    });
});
