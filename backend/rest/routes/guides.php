<?php

require_once __DIR__ . '/../services/GuidesService.php';

Flight::set('guidesService', new GuidesService());


Flight::route('GET /guides', function () {
    $service = Flight::get('guidesService');
    Flight::json($service->get_all());
});


Flight::route('GET /guides/@id', function ($id) {
    $service = Flight::get('guidesService');
    $guide = $service->get_by_id($id);
    if ($guide) {
        Flight::json($guide);
    } else {
        Flight::halt(404, "Guide not found");
    }
});


Flight::route('POST /guides', function () {
    $data = Flight::request()->data->getData();
    $service = Flight::get('guidesService');
    $created = $service->create($data);
    Flight::json($created, 201);
});

Flight::route('PUT /guides/@id', function ($id) {
    $data = Flight::request()->data->getData();
    $service = Flight::get('guidesService');
    $updated = $service->update($id, $data);
    Flight::json($updated);
});


Flight::route('DELETE /guides/@id', function ($id) {
    $service = Flight::get('guidesService');
    $success = $service->delete($id);
    Flight::json(['deleted' => $success]);
});
