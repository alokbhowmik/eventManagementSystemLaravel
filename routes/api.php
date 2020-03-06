<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/savedata', 'Usercontroller@saveUserData');
Route::get('/viewEmployee', 'EmployeControllere@viewEmployee')->middleware('checktoken');
Route::get('/deleteEmployee/{id}', 'EmployeControllere@deleteEmployee');
Route::post('/login', 'Usercontroller@userLogin');
Route::get('/checktoken', "Usercontroller@showUserData")->middleware('checktoken');
Route::get('/showevents',"Event@showEvents");
Route::get('/delete_events/{id}',"Event@deleteEvent");
Route::get('/viewUsers',"Usercontroller@viewUsers");
Route::post('/addevent', "Event@addEvent");
// Route::get('/deleteUser/{id}',"EmployeControllere@deleteEmployee");