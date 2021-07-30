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


// Pages
Route::get('/home','PageController@viewHome')->name('home');
Route::any('/PEA-Filed','PageController@PEAinProcess')->name('PEA_Filed');
Route::any('/PEA-Approval','PageController@PEAapproval')->name('PEA_Approval');


//Options
Route::get('/get-pos','OptionsController@getPosition');
Route::get('/get-emp','OptionsController@getEmployeePEA');
Route::get('/get-loc','OptionsController@getLocation');


//PEA
Route::post('/PEA-get','PEAController@getPEAFiled');
Route::post('/PEA-insert','PEAController@insertPEA');
Route::post('/PEA-update','PEAController@updatePEA');
Route::get('/PEA-Filed/PEA-rating/{id}','PEAController@ratePEA');
Route::post('/PEA-Rate-insert','PEAController@insertRatings');
Route::post('/PEA-Rate-update','PEAController@updateRatings');
Route::post('/PEA-comment-get/{id}','PEAController@monthlyComments');
Route::post('/PEA-comment-insert','PEAController@insertMonthlyComments');
Route::post('/PEA-comment-update','PEAController@updateMonthlyComments');
Route::post('/PEA-recom-update','PEAController@updateRecomLetter');
Route::post('/PEA-Approval-get','PEAController@getPEAApproved');



Route::get('/zxc',function(){
    DD(Myhelper::decrypt(Session::get('Department_ID')));
});


