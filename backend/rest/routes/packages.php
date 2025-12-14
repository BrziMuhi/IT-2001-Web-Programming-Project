<?php

require_once __DIR__ . '/../services/PackagesService.php';

Flight::set('packagesService', new PackagesService());


Flight::route('GET /packages', function () {
    $service = Flight::get('packagesService');
    Flight::json($service->get_all());
});


Flight::route('GET /packages/@id', function ($id) {
    $service = Flight::get('packagesService');
    $pkg = $service->get_by_id((int)$id);

    if ($pkg) {
        Flight::json($pkg);
    } else {
        Flight::halt(404, 'Package not found');
    }
});


Flight::route('GET /packages/by-tour/@tour_id', function ($tour_id) {
    $service = Flight::get('packagesService');
    $result = $service->get_by_tour((int)$tour_id);
    Flight::json($result);
});

Flight::route('POST /packages', function () {
    $data = Flight::request()->data->getData();
    $service = Flight::get('packagesService');
    $created = $service->create($data);
    Flight::json($created, 201);
});


Flight::route('PUT /packages/@id', function ($id) {
    $data = Flight::request()->data->getData();
    $service = Flight::get('packagesService');
    $updated = $service->update((int)$id, $data);

    if ($updated) {
        Flight::json($updated);
    } else {
        Flight::halt(404, 'Package not found');
    }
});


Flight::route('DELETE /packages/@id', function ($id) {
    $service = Flight::get('packagesService');
    $ok = $service->delete((int)$id);

    if ($ok) {
        Flight::json(['message' => 'Deleted']);
    } else {
        Flight::halt(404, 'Package not found');
    }
});

?>