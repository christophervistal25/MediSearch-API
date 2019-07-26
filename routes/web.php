<?php

$router->get('/owners', 'OwnerController@index');

$router->group(['prefix' => 'owner'], function () use ($router) {
	$router->post('/login', 'OwnerController@login');
	$router->post('/', 'OwnerController@store');    
});
