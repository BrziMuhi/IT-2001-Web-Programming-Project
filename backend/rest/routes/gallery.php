<?php

require_once __DIR__ . '/../services/GalleryService.php';

Flight::set('galleryService', new GalleryService());

/**
 * @OA\Get(
 *     path="/gallery",
 *     tags={"gallery"},
 *     summary="Get all gallery items",
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /gallery', function () {
    require_roles(['admin', 'user']);

    $service = Flight::get('galleryService');
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/gallery/{id}",
 *     tags={"gallery"},
 *     summary="Get gallery item by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /gallery/@id', function ($id) {
    require_roles(['admin', 'user']);

    $service = Flight::get('galleryService');
    $item = $service->get_by_id((int)$id);

    if ($item) {
        Flight::json($item);
    } else {
        Flight::halt(404, 'Gallery item not found');
    }
});

/**
 * @OA\Get(
 *     path="/tours/{id}/gallery",
 *     tags={"gallery"},
 *     summary="Get gallery items for a tour",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /tours/@id/gallery', function ($id) {
    require_roles(['admin', 'user']);

    $service = Flight::get('galleryService');
    Flight::json($service->get_by_tour_id((int)$id));
});
