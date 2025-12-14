<?php

require_once __DIR__ . '/../services/UsersService.php';

Flight::set('users_service', new UsersService());

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /users', function () {
    $service = Flight::get('users_service');
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('GET /users/@id', function ($id) {
    $service = Flight::get('users_service');
    $user = $service->get_by_id((int)$id);

    if ($user) {
        Flight::json($user);
    } else {
        Flight::halt(404, 'User not found');
    }
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"users"},
 *     summary="Create a user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Muhamed"),
 *             @OA\Property(property="email", type="string", example="muhamed.sekic@stu.ibu.edu.ba"),
 *             @OA\Property(property="password", type="string", example="secret")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('POST /users', function () {
    $service = Flight::get('users_service');
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update a user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Muhamed"),
 *             @OA\Property(property="email", type="string", example="muhamed.sekic@stu.ibu.edu.ba"),
 *             @OA\Property(property="password", type="string", example="secret")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('PUT /users/@id', function ($id) {
    $service = Flight::get('users_service');
    $data = Flight::request()->data->getData();
    Flight::json($service->update((int)$id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('DELETE /users/@id', function ($id) {
    $service = Flight::get('users_service');
    $ok = $service->delete((int)$id);

    if ($ok) {
        Flight::json(['status' => 'deleted']);
    } else {
        Flight::halt(404, 'User not found');
    }
});

/**
 * @OA\Post(
 *     path="/login",
 *     tags={"auth"},
 *     summary="Login",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="muhamed.sekic@stu.ibu.edu.ba"),
 *             @OA\Property(property="password", type="string", example="secret")
 *         )
 *     ),
 *     @OA\Response(response=200, description="OK")
 * )
 */
Flight::route('POST /login', function () {
    $service = Flight::get('users_service');
    $data = Flight::request()->data->getData();

    try {
        $user = $service->login($data['email'], $data['password']);

        Flight::json([
            'message' => 'User logged in successfully',
            'data' => $user
        ]);
    } catch (Exception $e) {
        Flight::halt(401, 'Invalid email or password');
    }
});

?>
