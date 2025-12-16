<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

// uključi servise
require_once __DIR__ . '/services/AuthService.php';

// registruj servise
Flight::register('auth_service', 'AuthService');

Flight::set('flight.log_errors', true);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/*

 AUTHORIZATION HELPERS

*/
function require_role($role) {
    $user = Flight::get('user');

    if (!$user || !isset($user->role)) {
        Flight::halt(403, 'Forbidden');
    }

    if ($user->role !== $role) {
        Flight::halt(403, 'Access denied');
    }
}

function require_roles($roles) {
    $user = Flight::get('user');

    if (!$user || !isset($user->role)) {
        Flight::halt(403, 'Forbidden');
    }

    if (!in_array($user->role, $roles)) {
        Flight::halt(403, 'Access denied');
    }
}

/*
 AUTHENTICATION MIDDLEWARE

*/
Flight::route('/*', function () {

    // javne rute (bez tokena)
    if (
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0 ||
        strpos(Flight::request()->url, '/docs') === 0 ||
        Flight::request()->url === '/'
    ) {
        return true;
    }

    try {
        $token = Flight::request()->getHeader('Authorization');

        if ($token && stripos($token, 'Bearer ') === 0) {
            $token = trim(substr($token, 7));
        }

        if (!$token) {
            Flight::halt(401, 'Missing Authentication header');
        }



        $decoded = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::set('user', $decoded->user);

        return true;

    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

/*

 TEST ROOT

*/
Flight::route('GET /', function () {
    echo 'API IS WORKING';
});

/*

|AUTH RUTE

*/
require_once __DIR__ . '/routes/AuthRoutes.php';

 // rute 
require_once __DIR__ . '/routes/guides.php';
require_once __DIR__ . '/routes/tours.php';
require_once __DIR__ . '/routes/packages.php';
require_once __DIR__ . '/routes/bookings.php';
require_once __DIR__ . '/routes/users.php';
require_once __DIR__ . '/routes/contacts.php';
require_once __DIR__ . '/routes/gallery.php';

Flight::start();
