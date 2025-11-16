<?php

require_once __DIR__ . '/../vendor/autoload.php';

Flight::set('flight.log_errors', true);

Flight::route('GET /', function () {
    echo 'Api IS WORKING';
});

// rute
require_once __DIR__ . '/routes/guides.php';
require_once __DIR__ . '/routes/tours.php';
require_once __DIR__ . '/routes/packages.php';
require_once __DIR__ . '/routes/bookings.php';
require_once __DIR__ . '/routes/users.php';
require_once __DIR__ . '/routes/contacts.php';
require_once __DIR__ . '/routes/gallery.php';

Flight::start();
