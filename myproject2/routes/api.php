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


Route::group(['middleware' => 'auth:api'], function() {
    //logout
    Route::post('logout', 'Auth\LoginController@logout');
    //Project Management
    Route::get('projects', 'ProjectController@index');
    Route::get('projects/{project}', 'ProjectController@show');
    Route::post('projects', 'ProjectController@store');
    Route::put('projects/{project}', 'ProjectController@update');
    Route::delete('projects/{project}', 'ProjectController@delete');
    //User Management
    Route::get('users', 'UserController@index');
    Route::get('users/{user}', 'UserController@show');
    Route::put('users/{user}', 'UserController@update');
    Route::delete('users/{user}', 'UserController@delete');
    Route::put('user_password/{user}', 'Auth\ChangePasswordController@change_password');
    Route::post('user', 'UserController@store');

    //Project Role Management
    Route::get('projectmembers', 'ProjectMemberController@index');
    Route::get('projectmembers/{member}', 'ProjectMemberController@show');
    Route::get('projectmembers/{project}/user/{user}', 'ProjectMemberController@show_user_projects');
    Route::get('memberofprojects/{project}', 'ProjectMemberController@show_project_members');
    Route::post('projectmembers', 'ProjectMemberController@store');
    //Route::put('projectmembers/projects/{project}/user/{user}', 'ProjectMemberController@update_member');
    Route::put('projectmembers/{member}', 'ProjectMemberController@updatewithid');
    Route::delete('projectmembers/{member_id}', 'ProjectMemberController@delete');

    //Task Management
    Route::post('tasks', 'TaskController@store');
    Route::put('tasks/{task}', 'TaskController@update');
    Route::delete('tasks/{task}', 'TaskController@delete');
    Route::get('tasks', 'TaskController@index');
    Route::get('tasks/{task}', 'TaskController@show');
    Route::get('user_tasks/{user_id}', 'TaskController@show_user_tasks');
    //Route::get('project_tasks/{project_id}', 'TaskController@show_project_tasks');


    //statistics
    Route::get('projects_statistics', 'ProjectController@statistics');
    Route::get('user_statistics_old/{user}', 'ProjectController@statistics_user');
    Route::get('user_statistics/{user}', 'ProjectController@statistics_user_new');
});
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');


