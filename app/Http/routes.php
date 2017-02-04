<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Contact;

Route::get('/', function () {
    return view('welcome');
	
});


Route::get('/showcontacts', 'ContactsController@index');

Route::get('/cargarcsv','ContactsController@createcsv');

Route::post('/cargarcsv','ContactsController@storecsv');

Route::get('/cargaragents','ContactsController@createagent' );

Route::get('/match', 'ContactsController@match');

Route::get('/matchDistance', 'ContactsController@matchDistance');

Route::post('/addAgents','ContactsController@addAgents'); 


