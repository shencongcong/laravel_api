<?php

Route::any('serve/{appid}', 'WechatController@serve');
Route::any('openPlatform', 'OpenPlatformController@index');
Route::any('openPlatform/callBack', 'OpenPlatformController@callBack');


// 用户信息
Route::group(['prefix' => 'user'], function () {
    Route::get('user', 'UserController@user');
    Route::get('show', 'UserController@show');
    Route::get('shows', 'UserController@shows');
});

// 二维码
Route::group(['prefix' => 'qrCode'], function () {
    Route::get('forever', 'qrCodeController@forever');
    Route::get('foreverUrl', 'qrCodeController@foreverUrl');
    Route::get('temporary', 'qrCodeController@temporary');
});

//网页授权
Route::group(['prefix' => 'oauth'], function () {
    Route::get('snsapiBase', 'OauthController@snsapiBase');
    Route::get('callback', 'OauthController@callback');
});

// 模板消息
Route::group(['prefix' => 'template'], function () {
    Route::get('send', 'TemplatesController@send');
});

// 微信jssdk
Route::group(['prefix' => 'jsSdk'], function () {
    Route::get('getLocation', 'JsSdkController@getLocation');
});

// 微信自动回复
Route::group(['prefix' => 'reply'], function () {
    Route::get('reply', 'ReplyController@reply');
});