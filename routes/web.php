<?php

$router->get('/owners', 'OwnerController@index');
$router->get('/stores', 'StoreController@index');

$router->group(['prefix' => 'owner'], function () use ($router) {
	
	$router->post('/login', ['middleware' => 'owner', 'uses' => 'OwnerController@login']);
	$router->post('/', 'OwnerController@store');    
	$router->post('/store', 'StoreController@store');

	$router->post('/{id}/store', 'OwnerStoreController@addStore');
	$router->get('/{id}/stores', 'OwnerStoreController@stores');

	$router->put('/store/{store}', 'StoreController@update');

	$router->post('/{ownerId}/store/{storeId}', 'OwnerStoreController@assign');
});

$router->get('/store/{id}/medicines', 'StoreMedicineController@medicines');
$router->post('/store/{id}/medicine', 'StoreMedicineController@entry');

$router->get('/store/{storeId}/comments', 'StoreCommentController@show');
$router->post('/store/comment', 'StoreCommentController@store');
$router->put('/store/comment/{commentId}', 'StoreCommentController@update');

$router->post('/comment/reply', 'ReplyController@store');
$router->put('/comment/reply/{replyId}', 'ReplyController@update');

$router->put('medicine/{id}', 'MedicineController@update');

$router->group(['prefix' => 'user'], function () use ($router) {
	$router->post('/login', 'UserController@login');
	$router->post('/register', 'UserController@register');
	$router->get('/{id}', 'UserController@show');
	$router->put('/{id}', 'UserController@update');
});