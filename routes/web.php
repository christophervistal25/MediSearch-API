<?php

$router->get('/owners', 'OwnerController@index');

$router->group(['prefix' => 'owner'], function () use ($router) {
	$router->post('/login', 'OwnerController@login', ['middleware' => 'owner']);
	
	$router->post('/', 'OwnerController@store');    
	$router->post('/store', 'StoreController@store');

	$router->post('/{id}/store', 'OwnerStoreController@addStore');
	$router->get('/{id}/stores', 'OwnerStoreController@stores');

	$router->put('/store/{store}', 'StoreController@update');

	$router->post('/{ownerId}/store/{storeId}', 'OwnerStoreController@assign');
});

$router->get('/store/{id}/medicines', 'StoreMedicineController@medicines');
$router->post('/store/{id}/medicine', 'StoreMedicineController@entry');

$router->put('medicine/{id}', 'MedicineController@update');

$router->group(['prefix' => 'user'], function () use ($router) {
	$router->post('/login', 'UserController@login');
	$router->post('/register', 'UserController@register');
	$router->get('/{id}', 'UserController@show');
	$router->put('/{id}', 'UserController@update');
});