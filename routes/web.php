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

//Options
Route::get('/get-pos','OptionsController@getPosition');
Route::get('/get-emp','OptionsController@getEmployeePEA');



//PEA
Route::post('/PEA-get','PEAController@getPEAFiled');
Route::post('/PEA-insert','PEAController@insertPEA');

Route::get('/zxc',function(){
    DD(Myhelper::decrypt(Session::get('Employee_ID')));
});


