<?php

/**
 * @var Dingo\Api\Routing\Router $router
 */

use Dingo\Api\Routing\Router;

$router->group(['prefix' => 'v1', 'namespace' => 'V1'], function (Router $router) {

    $router->group(['prefix' => 'auth'], function (Router $router) {

        $router->post('login', [
            'uses' => 'Auth\LoginController@login',
            'middleware' => 'api.throttle',
            'limit' => 1,
            'expires' => 5
        ]);
        $router->post('verify', 'Auth\LoginController@verify');

        $router->group(['middleware' => ['patient_auth']], function () use ($router) {
            $router->post('register', 'Auth\RegistrationController@index');
            $router->post('logout', 'Auth\LoginController@logout');
        });
    });

    $router->group(['middleware' => ['patient_auth']], function () use ($router) {

        $router->group(['prefix' => 'city'], function (Router $router) {
            $router->get('list', 'CityController@getList');
            $router->get('archive/list', 'CityController@getArchiveList');
            $router->post('create', 'CityController@create');
        });

        $router->group(['prefix' => 'file'], function (Router $router) {
            $router->post('upload', 'FileController@upload');
            $router->delete('delete', 'FileController@delete');
        });

        $router->group(['middleware' => ['patient_registered']], function () use ($router) {

            $router->group(['prefix' => 'profile'], function (Router $router) {

                $router->get('show', 'ProfileController@show');
                $router->patch('update', 'ProfileController@update');
                $router->post('remove-avatar', 'ProfileController@removeAvatar');
            });

            $router->group(['prefix' => 'visit'], function (Router $router) {
                $router->get('by-id', 'VisitController@getById');
                $router->get('list', 'VisitController@getList');
                $router->post('create', 'VisitController@create');
                $router->post('private-comment', 'VisitController@privateComment');
                $router->post('add-file', 'VisitController@addFile');
            });
        });

        $router->group(['prefix' => 'applozic'], function (Router $router) {
            $router->delete('message/delete', 'ApplozicController@deleteMessage');
        });
    });
});

