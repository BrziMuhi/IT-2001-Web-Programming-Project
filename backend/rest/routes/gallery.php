<?php

require_once __DIR__ . '/../services/GalleryService.php';

Flight::set('gallery_service', new GalleryService());

Flight::route('GET /gallery', function () {
    $service = Flight::get('gallery_service');
    Flight::json($service->get_all());
});


Flight::route('GET /gallery/@id', function ($id) {
    $service = Flight::get('gallery_service');
    $item = $service->get_by_id((int)$id);

    if ($item) {
        Flight::json($item);
    } else {
        Flight::halt(404, 'Gallery item not found');
    }
});


Flight::route('GET /tours/@id/gallery', function ($tour_id) {
    $service = Flight::get('gallery_service');
    Flight::json($service->get_by_tour((int)$tour_id));
});
