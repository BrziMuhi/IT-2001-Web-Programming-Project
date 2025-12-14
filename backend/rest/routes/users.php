<?php

require_once __DIR__ . '/../services/UsersService.php';

Flight::set('users_service', new UsersService());

Flight::route('GET /users', function () {
    $service = Flight::get('users_service');
    Flight::json($service->get_all());
});


Flight::route('GET /users/@id', function ($id) {
    $service = Flight::get('users_service');
    $user = $service->get_by_id((int)$id);

    if ($user) {
        Flight::json($user);
    } else {
        Flight::halt(404, 'User not found');
    }
});


Flight::route('POST /users', function () {
    $service = Flight::get('users_service');
    $data = Flight::request()->data->getData();
    $created = $service->add($data);
    Flight::json($created, 201);
});


Flight::route('PUT /users/@id', function ($id) {
    $service = Flight::get('users_service');
    $data = Flight::request()->data->getData();
    $updated = $service->update($data, (int)$id);

    if ($updated) {
        Flight::json($updated);
    } else {
        Flight::halt(404, 'User not found');
    }
});


Flight::route('DELETE /users/@id', function ($id) {
    $service = Flight::get('users_service');
    $ok = $service->delete((int)$id);

    if ($ok) {
        Flight::json(['status' => 'deleted']);
    } else {
        Flight::halt(404, 'User not found');
    }
});





Flight::route('POST /login', function() {
    $data = Flight::request()->data->getData();

    $service = Flight::get('users_service');

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
