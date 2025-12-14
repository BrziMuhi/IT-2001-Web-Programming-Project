<?php

require_once __DIR__ . '/../services/ToursService.php';

Flight::set('toursService', new ToursService());

/**
 * @OA\Get(
 *     path="/tours",
 *     tags={"tours"},
 *     summary="Get all tours",
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /tours', function () {
    require_roles(['admin', 'user']);

    $service = Flight::get('toursService');
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/tours/active",
 *     tags={"tours"},
 *     summary="Get active tours",
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /tours/active', function () {
    require_roles(['admin', 'user']);

    $service = Flight::get('toursService');
    Flight::json($service->get_active());
});

/**
 * @OA\Get(
 *     path="/tours/{id}",
 *     tags={"tours"},
 *     summary="Get tour by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /tours/@id', function ($id) {
    require_roles(['admin', 'user']);

    $service = Flight::get('toursService');
    $tour = $service->get_by_id((int)$id);

    if ($tour) {
        Flight::json($tour);
    } else {
        Flight::halt(404, 'Tour not found');
    }
});

/**
 * @OA\Post(
 *     path="/tours",
 *     tags={"tours"},
 *     summary="Create a tour",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Tour name"),
 *             @OA\Property(property="description", type="string", example="Tour description"),
 *             @OA\Property(property="is_active", type="boolean", example="1")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('POST /tours', function () {
    require_role('admin');

    $service = Flight::get('toursService');
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/tours/{id}",
 *     tags={"tours"},
 *     summary="Update a tour",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Tour name"),
 *             @OA\Property(property="description", type="string", example="Tour description"),
 *             @OA\Property(property="is_active", type="boolean", example="1")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('PUT /tours/@id', function ($id) {
    require_role('admin');

    $service = Flight::get('toursService');
    $data = Flight::request()->data->getData();
    Flight::json($service->update((int)$id, $data));
});

/**
 * @OA\Delete(
 *     path="/tours/{id}",
 *     tags={"tours"},
 *     summary="Delete a tour",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('DELETE /tours/@id', function ($id) {
    require_role('admin');

    $service = Flight::get('toursService');
    $ok = $service->delete((int)$id);

    if ($ok) {
        Flight::json(['status' => 'deleted']);
    } else {
        Flight::halt(404, 'Tour not found');
    }
});
