<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Project;
use App\Http\Controllers\Auth\LoginController;
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


// Route::get('projects', function (){
//     return Project::all();
// });

// Route::get('project\{id}',function($id){
//     return Project::find($id);

// });

// Route::post('projects', function(Request $request){
//     return Project::create($request->all());
// });

// Route::put('Project\{id}', function(Request $request, $id){
//     $project = Project::findOrFail($id);
//     $project->update($request->all());
//     return $project;
// });

// Route::delete('Project\{id}', function($id){
//     Project::find($id)->delete();
//     return 204;
// });

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('projects', 'ProjectController@index');
    Route::get('projects/{project}', 'ProjectController@show');
    Route::post('projects', 'ProjectController@store');
    Route::put('projects/{project}', 'ProjectController@update');
    Route::delete('projects/{project}', 'ProjectController@delete');
});
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

//Route::post('/login', [LoginController::class, 'login']);
