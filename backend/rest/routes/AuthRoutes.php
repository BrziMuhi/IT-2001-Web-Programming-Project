<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::group('/auth', function() {

    Flight::route('POST /register', function() {
        $data = Flight::request()->data->getData();
        $response = Flight::auth_service()->register($data);

        if ($response['success']) {
            Flight::json($response);
        } else {
            Flight::halt(500, $response['error']);
        }
    });

    Flight::route('POST /login', function() {
        $data = Flight::request()->data->getData();
        $response = Flight::auth_service()->login($data);

        if ($response['success']) {
            Flight::json($response);
        } else {
            Flight::halt(401, $response['error']);
        }
    });

});
?>