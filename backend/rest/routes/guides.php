<?php

require_once __DIR__ . '/../services/GuidesService.php';

Flight::set('guidesService', new GuidesService());

/**
 * @OA\Get(
 *     path="/guides",
 *     tags={"guides"},
 *     summary="Get all guides",
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /guides', function () {
    $service = Flight::get('guidesService');
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/guides/{id}",
 *     tags={"guides"},
 *     summary="Get guide by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /guides/@id', function ($id) {
    $service = Flight::get('guidesService');
    $guide = $service->get_by_id((int)$id);

    if ($guide) {
        Flight::json($guide);
    } else {
        Flight::halt(404, 'Guide not found');
    }
});

/**
 * @OA\Post(
 *     path="/guides",
 *     tags={"guides"},
 *     summary="Create a guide",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Guide Name"),
 *             @OA\Property(property="bio", type="string", example="Short bio"),
 *             @OA\Property(property="phone", type="string", example="+387...")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('POST /guides', function () {
    $service = Flight::get('guidesService');
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/guides/{id}",
 *     tags={"guides"},
 *     summary="Update guide",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Guide Name"),
 *             @OA\Property(property="bio", type="string", example="Short bio"),
 *             @OA\Property(property="phone", type="string", example="+387...")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('PUT /guides/@id', function ($id) {
    $service = Flight::get('guidesService');
    $data = Flight::request()->data->getData();
    Flight::json($service->update((int)$id, $data));
});

/**
 * @OA\Delete(
 *     path="/guides/{id}",
 *     tags={"guides"},
 *     summary="Delete guide",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('DELETE /guides/@id', function ($id) {
    $service = Flight::get('guidesService');
    $ok = $service->delete((int)$id);

    if ($ok) {
        Flight::json(['status' => 'deleted']);
    } else {
        Flight::halt(404, 'Guide not found');
    }
});

?>
