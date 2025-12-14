<?php

require_once __DIR__ . '/../services/ToursService.php';

Flight::set('toursService', new ToursService());


Flight::route('GET /tours', function () {
    $service = Flight::get('toursService');
    Flight::json($service->get_all());
});


Flight::route('GET /tours/active', function () {
    $service = Flight::get('toursService');
    Flight::json($service->get_active());
});


Flight::route('GET /tours/@id', function ($id) {
    $service = Flight::get('toursService');
    $tour = $service->get_by_id((int)$id);

    if ($tour) {
        Flight::json($tour);
    } else {
        Flight::halt(404, 'Tour not found');
    }
});


Flight::route('POST /tours', function () {
    $data = Flight::request()->data->getData();
    $service = Flight::get('toursService');
    $created = $service->create($data);
    Flight::json($created, 201);
});


Flight::route('PUT /tours/@id', function ($id) {
    $data = Flight::request()->data->getData();
    $service = Flight::get('toursService');
    $updated = $service->update((int)$id, $data);
    if ($updated) {
        Flight::json($updated);
    } else {
        Flight::halt(404, 'Tour not found');
    }
});

Flight::route('DELETE /tours/@id', function ($id) {
    $service = Flight::get('toursService');
    $ok = $service->delete((int)$id);
    if ($ok) {
        Flight::json(['message' => 'Deleted']);
    } else {
        Flight::halt(404, 'Tour not found');
    }
});

?>