<?php

require_once __DIR__ . '/../services/BookingsService.php';

Flight::set('bookings_service', new BookingsService());

Flight::route('GET /bookings', function () {
    $service = Flight::get('bookings_service');
    Flight::json($service->get_all());
});


Flight::route('GET /bookings/@id', function ($id) {
    $service = Flight::get('bookings_service');
    $booking = $service->get_by_id((int)$id);

    if ($booking) {
        Flight::json($booking);
    } else {
        Flight::halt(404, 'Booking not found');
    }
});


Flight::route('GET /users/@id/bookings', function ($user_id) {
    $service = Flight::get('bookings_service');
    Flight::json($service->get_by_user((int)$user_id));
});


Flight::route('GET /tours/@id/bookings', function ($tour_id) {
    $service = Flight::get('bookings_service');
    Flight::json($service->get_by_tour((int)$tour_id));
});

Flight::route('POST /bookings', function () {
    $service = Flight::get('bookings_service');
    $data = Flight::request()->data->getData();
    $created = $service->add($data);
    Flight::json($created, 201);
});


Flight::route('PUT /bookings/@id', function ($id) {
    $service = Flight::get('bookings_service');
    $data = Flight::request()->data->getData();
    $updated = $service->update($data, (int)$id);

    if ($updated) {
        Flight::json($updated);
    } else {
        Flight::halt(404, 'Booking not found');
    }
});


Flight::route('DELETE /bookings/@id', function ($id) {
    $service = Flight::get('bookings_service');
    $ok = $service->delete((int)$id);

    if ($ok) {
        Flight::json(['status' => 'deleted']);
    } else {
        Flight::halt(404, 'Booking not found');
    }
});
