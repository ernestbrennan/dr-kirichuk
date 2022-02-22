<?php

use Dingo\Api\Routing\Router;

/**
 * @var Dingo\Api\Routing\Router $router
 */

$router->group(['prefix' => 'v1', 'namespace' => 'V1'], function (Router $router) {

    $router->group(['middleware' => ['doctor_auth']], function (Router $router) {

        $router->group(['prefix' => 'patient'], function () use ($router) {
            $router->post('list', 'PatientController@getList');
            $router->get('by-id', 'PatientController@getById');
            $router->post('add-comment', 'PatientController@addComment');
        });

        $router->group(['prefix' => 'city'], function (Router $router) {
            $router->get('list', 'CityController@getList');
        });

        $router->group(['prefix' => 'tag'], function (Router $router) {
            $router->get('list', 'TagController@getList');
        });

        $router->group(['prefix' => 'file'], function (Router $router) {
            $router->post('upload', 'FileController@upload');
            $router->delete('delete', 'FileController@delete');
        });

        $router->group(['prefix' => 'visit'], function (Router $router) {
            $router->get('by-id', 'VisitController@getById');
            $router->get('list', 'VisitController@getList');
            $router->post('create', 'VisitController@create');
            $router->patch('update', 'VisitController@update');
            $router->post('private-comment', 'VisitController@privateComment');
            $router->delete('delete', 'VisitController@delete');
        });


        $router->group(['prefix' => 'scheduled-message'], function (Router $router) {
            $router->get('list', 'ScheduledMessageController@getList');
            $router->post('create', 'ScheduledMessageController@create');
            $router->patch('update', 'ScheduledMessageController@update');
            $router->delete('delete', 'ScheduledMessageController@delete');
        });

        $router->group(['prefix' => 'mailing'], function (Router $router) {
            $router->post('mass/create', 'MailingController@massCreate');

            $router->get('birthday/get', 'MailingController@birthdayGet');
            $router->post('birthday/create', 'MailingController@birthdayCreate');
            $router->delete('birthday/delete', 'MailingController@birthdayDelete');
        });

        $router->group(['prefix' => 'applozic'], function (Router $router) {
            $router->delete('message/delete', 'ApplozicController@deleteMessage');
        });

        $router->group(['prefix' => 'notification'], function (Router $router) {
            $router->get('list', 'NotificationController@getList');
            $router->post('read', 'NotificationController@read');
        });

        $router->group(['prefix' => 'fcm'], function (Router $router) {
            $router->post('save-token', 'FcmController@saveToken');
        });
    });
});


