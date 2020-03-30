<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('member', 'MemberController');
Route::resource('game', 'GameController');

Route::view('admin/members', 'member.admin');
Route::view('admin/games', 'game.admin');

Route::get('leaderboard', 'LeaderboardController@index');
