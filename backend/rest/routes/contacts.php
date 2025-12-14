<?php

require_once __DIR__ . '/../services/ContactsService.php';

Flight::set('contactsService', new ContactsService());

/**
 * @OA\Get(
 *     path="/contacts",
 *     tags={"contacts"},
 *     summary="Get all contact messages",
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /contacts', function () {
    $service = Flight::get('contactsService');
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/contacts/{id}",
 *     tags={"contacts"},
 *     summary="Get contact message by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /contacts/@id', function ($id) {
    $service = Flight::get('contactsService');
    $contact = $service->get_by_id((int)$id);

    if ($contact) {
        Flight::json($contact);
    } else {
        Flight::halt(404, 'Contact not found');
    }
});

/**
 * @OA\Post(
 *     path="/contacts",
 *     tags={"contacts"},
 *     summary="Create contact message",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Muhamed"),
 *             @OA\Property(property="email", type="string", example="muhamed@example.com"),
 *             @OA\Property(property="message", type="string", example="Hello")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('POST /contacts', function () {
    $service = Flight::get('contactsService');
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

?>
