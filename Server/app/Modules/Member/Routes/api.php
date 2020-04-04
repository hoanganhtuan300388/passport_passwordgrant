<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'MemberController@register')->name('members.register');
Route::post('login', 'MemberController@login')->name('members.login');

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('logout', 'MemberController@logout')->name('members.logout');
    Route::get('profile', 'MemberController@profile')->name('members.profile');
    Route::put('profile/member', 'MemberController@editMember')->name('members.editMember');
    Route::put('profile/contact', 'MemberController@editContact')->name('members.editContact');
    Route::put('profile/setting', 'MemberController@editSetting')->name('members.editSetting');
    Route::post('friend', 'MemberController@friend')->name('members.friend');
    Route::post('group', 'MemberController@group')->name('members.group');
    Route::get('contact', 'ContactController@index')->name('members.index');

    Route::post('groups', 'GroupController@store')->name('groups.store');

});