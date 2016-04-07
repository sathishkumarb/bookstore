<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/*
Route::get('/', function()
{
	return View::make('hello');
});*/
Route::get('/', array('as' => 'index', 'uses' => 'IndexController@index'));
Route::get('add', array('as' => 'login', 'uses' => 'IndexController@addBooks'));
Route::post('add', array('as' => 'add', 'uses' => 'IndexController@processAdd')); 
Route::get('getAuthors', array('as' => 'getAuthors', 'uses' => 'IndexController@getAuthors')); 
Route::get('getPublishers', array('as' => 'getPublishers', 'uses' => 'IndexController@getPublishers'));
Route::get('checkBookname', array('as' => 'checkBookname', 'uses' => 'IndexController@checkBookname')); 
Route::get('bookview/{id}', array('as' => 'bookview', 'uses' => 'IndexController@bookview')); 
Route::get('searchBook', array('as' => 'searchBook', 'uses' => 'IndexController@searchBook')); 

