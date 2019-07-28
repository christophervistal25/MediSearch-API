<?php

$router->get('/owners', 'OwnerController@index');

$router->group(['prefix' => 'owner'], function () use ($router) {
	$router->post('/login', 'OwnerController@login', ['middleware' => 'owner']);
	
	$router->post('/', 'OwnerController@store');    
	$router->post('/store', 'StoreController@store');

	$router->post('/{id}/store', 'OwnerStoreController@addStore');
	$router->get('/{id}/stores', 'OwnerStoreController@stores');

	$router->put('/store/{store}', 'StoreController@update');
});
