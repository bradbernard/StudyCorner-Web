<?php

//use App\User;
//use Vinkla\Pusher\Facades\Pusher as LaravelPusher;
//use App\UserClass;
//use App\SchoolClass;
//use App\StudySession;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/test', 'SessionController@fireTest');

Route::post('/api/user/login', 'LoginController@handleLogin');
Route::post('/api/user/create', 'ApiController@postRegister');
Route::post('/api/user/priority', 'PriorityController@setPriority');
Route::post('/api/user/sessions', 'SessionController@crossRefSession');
Route::post('/api/user/createSession', 'SessionController@createSession');
Route::post('api/user/sessions/{id}', 'SessionController@giveUsers');
Route::post('api/user/session/changeStatus', 'SessionController@changeStatus');
Route::post('api/user/session/setToken', 'ApiController@setToken');
Route::post('api/user/session/checkClass', 'SessionController@checkClass');


/*


|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
