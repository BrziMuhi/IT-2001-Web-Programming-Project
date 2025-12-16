<?php

require_once __DIR__ . '/../services/PackagesService.php';

Flight::set('packagesService', new PackagesService());

/**
 * @OA\Get(
 *     path="/packages",
 *     tags={"packages"},
 *     summary="Get all packages",
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /packages', function () {
    require_roles(['admin', 'user']);

    $service = Flight::get('packagesService');
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/packages/{id}",
 *     tags={"packages"},
 *     summary="Get package by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /packages/@id', function ($id) {
    require_roles(['admin', 'user']);

    $service = Flight::get('packagesService');
    $package = $service->get_by_id((int)$id);

    if ($package) {
        Flight::json($package);
    } else {
        Flight::halt(404, 'Package not found');
    }
});

/**
 * @OA\Get(
 *     path="/packages/by-tour/{tour_id}",
 *     tags={"packages"},
 *     summary="Get packages by tour ID",
 *     @OA\Parameter(
 *         name="tour_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /packages/by-tour/@tour_id', function ($tour_id) {
    require_roles(['admin', 'user']);

    $service = Flight::get('packagesService');
    Flight::json($service->get_by_tour_id((int)$tour_id));
});

/**
 * @OA\Post(
 *     path="/packages",
 *     tags={"packages"},
 *     summary="Create a package",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="tour_id", type="integer", example="1"),
 *             @OA\Property(property="title", type="string", example="Package title"),
 *             @OA\Property(property="price", type="number", example="199.99")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('POST /packages', function () {
    require_role('admin');

    $service = Flight::get('packagesService');
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/packages/{id}",
 *     tags={"packages"},
 *     summary="Update a package",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="tour_id", type="integer", example="1"),
 *             @OA\Property(property="title", type="string", example="Package title"),
 *             @OA\Property(property="price", type="number", example="199.99")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('PUT /packages/@id', function ($id) {
    require_role('admin');

    $service = Flight::get('packagesService');
    $data = Flight::request()->data->getData();
    Flight::json($service->update((int)$id, $data));
});

/**
 * @OA\Delete(
 *     path="/packages/{id}",
 *     tags={"packages"},
 *     summary="Delete a package",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('DELETE /packages/@id', function ($id) {
    require_role('admin');

    $service = Flight::get('packagesService');
    $ok = $service->delete((int)$id);

    if ($ok) {
        Flight::json(['status' => 'deleted']);
    } else {
        Flight::halt(404, 'Package not found');
    }
});
