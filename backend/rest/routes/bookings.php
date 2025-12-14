<?php

require_once __DIR__ . '/../services/BookingsService.php';

Flight::set('bookings_service', new BookingsService());

/**
 * @OA\Get(
 *     path="/bookings",
 *     tags={"bookings"},
 *     summary="Get all bookings",
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /bookings', function () {
    require_roles(['admin', 'user']);

    $service = Flight::get('bookings_service');
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/bookings/{id}",
 *     tags={"bookings"},
 *     summary="Get booking by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /bookings/@id', function ($id) {
    require_roles(['admin', 'user']);

    $service = Flight::get('bookings_service');
    $booking = $service->get_by_id((int)$id);

    if ($booking) {
        Flight::json($booking);
    } else {
        Flight::halt(404, 'Booking not found');
    }
});

/**
 * @OA\Get(
 *     path="/users/{id}/bookings",
 *     tags={"bookings"},
 *     summary="Get bookings for a user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /users/@id/bookings', function ($id) {
    require_roles(['admin', 'user']);

    $service = Flight::get('bookings_service');
    Flight::json($service->get_by_user_id((int)$id));
});

/**
 * @OA\Get(
 *     path="/tours/{id}/bookings",
 *     tags={"bookings"},
 *     summary="Get bookings for a tour",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /tours/@id/bookings', function ($id) {
    require_roles(['admin', 'user']);

    $service = Flight::get('bookings_service');
    Flight::json($service->get_by_tour_id((int)$id));
});

/**
 * @OA\Post(
 *     path="/bookings",
 *     tags={"bookings"},
 *     summary="Create a booking",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example="1"),
 *             @OA\Property(property="tour_id", type="integer", example="1"),
 *             @OA\Property(property="persons", type="integer", example="2"),
 *             @OA\Property(property="date", type="string", example="2025-12-14")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('POST /bookings', function () {
    require_role('admin');

    $service = Flight::get('bookings_service');
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/bookings/{id}",
 *     tags={"bookings"},
 *     summary="Update booking",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example="1"),
 *             @OA\Property(property="tour_id", type="integer", example="1"),
 *             @OA\Property(property="persons", type="integer", example="2"),
 *             @OA\Property(property="date", type="string", example="2025-12-14")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('PUT /bookings/@id', function ($id) {
    require_role('admin');

    $service = Flight::get('bookings_service');
    $data = Flight::request()->data->getData();
    Flight::json($service->update((int)$id, $data));
});

/**
 * @OA\Delete(
 *     path="/bookings/{id}",
 *     tags={"bookings"},
 *     summary="Delete booking",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('DELETE /bookings/@id', function ($id) {
    require_role('admin');

    $service = Flight::get('bookings_service');
    $ok = $service->delete((int)$id);

    if ($ok) {
        Flight::json(['status' => 'deleted']);
    } else {
        Flight::halt(404, 'Booking not found');
    }
});
