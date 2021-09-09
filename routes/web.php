<?php

use App\Helper\MyHelper;
use App\Mail\MyTestMail;
use App\Mail\TestMail;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\CrapIndex;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Mail\Mailable;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Index
Route::any('/','AuthController@index');
Route::get('/logout','AuthController@logout')->name('logout');
Route::post('/pin-check','AuthController@getUserPIN');


// Pages
Route::get('/home','PageController@viewHome')->name('home');
Route::any('/PEA-Filed','PageController@PEAinProcess')->name('PEA_Filed');
Route::any('/PEA-Approval','PageController@PEAapproval')->name('PEA_Approval');
Route::get('/PEA-Report','PageController@PEAReports')->name('PEA_Report');
Route::any('/BI-Filed','PageController@BIinProcess')->name('BI_Filed');
Route::any('/BI-Approval','PageController@BIapproval')->name('BI_Approval');
Route::any('/Non-Reg','PageController@NonReg')->name('NonReg');
Route::any('/NPA','PageController@NPA')->name('NPA');
Route::any('/Probi','PageController@Probi')->name('Probi');



//Options
Route::get('/get-pos','OptionsController@getPosition');
Route::get('/get-emp','OptionsController@getEmployeePEA');
Route::get('/get-loc','OptionsController@getLocation');
Route::get('/get-dept','OptionsController@getDepartment');

//Probi
Route::get('/probi-list','OptionsController@getEmployeeDatatable');


//PEA
Route::post('/PEA-get','PEAController@getPEAFiled');
Route::post('/PEA-insert','PEAController@insertPEA');
Route::post('/PEA-update','PEAController@updatePEA');
Route::get('/PEA-rating/{id}','PEAController@ratePEA');
Route::post('/PEA-Rate-insert','PEAController@insertRatings');
Route::post('/PEA-Rate-update','PEAController@updateRatings');
Route::post('/PEA-comment-get/{id}','PEAController@monthlyComments');
Route::post('/PEA-comment-insert','PEAController@insertMonthlyComments');
Route::post('/PEA-comment-update','PEAController@updateMonthlyComments');
Route::post('/PEA-recom-update','PEAController@updateRecomLetter');
Route::post('/PEA-Approval-get','PEAController@getPEAApproved');
Route::post('/PEA-Approval-insert','PEAController@insertApprovedFile');
Route::post('/PEA-batch-approval','PEAController@batchApprovedFile');
Route::post('/PEA-disapprove','PEAController@disApproveFile');
Route::get('/PEA-report','ReportController@getNonRegReport');


//BI
Route::post('/BI-get','BIController@getBIFiled');
Route::get('/BI-filing/{id}','BIController@fileBI');
Route::post('/BI-insert','BIController@insertBI');
Route::post('/BI-update','BIController@updateBI');
Route::post('/BI-app-get','BIController@getBIApp');
Route::post('/BI-approve','BIController@approveBI');

//Non-Reg
Route::post('/NonReg-get','NonRegController@getNonRegApp');
Route::post('/NonReg-approve','NonRegController@batchApprovedFile');

//NPA
Route::post('/NPA-get','NPAController@getNPA');
Route::get('/NPA-Form/{id}','NPAController@getNPARec');
Route::get('/NPA-showPEA/{id}','NPAController@showPEA');
Route::post('/NPA-approve','NPAController@approveNPA');
Route::post('/NPA-batch-app','NPAController@batchApprovedNPA');

//REPORTS
Route::any('/RPT-PEA','ReportController@showRPTPEA')->name('RPT_PEA');
Route::any('/RPT-EP','ReportController@showRPTEP')->name('RPT_EP');
Route::any('/RPT-NPA','ReportController@showRPTNPA')->name('RPT_NPA');
Route::any('/RPT-RL','ReportController@showRPTRL')->name('RPT_RL');
Route::any('/RPT-NonReg','ReportController@showRPTNonReg')->name('RPT_NR');
Route::any('/RPT-BI','ReportController@showRPTBI')->name('RPT_BI');


Route::get('/zxc',function(){
    DD(Myhelper::decrypt(Session::get('PositionLevel_ID')));
});


