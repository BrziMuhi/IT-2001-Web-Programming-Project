<?php

require_once __DIR__ . '/../services/ContactsService.php';

Flight::set('contacts_service', new ContactsService());


Flight::route('GET /contacts', function () {
    $service = Flight::get('contacts_service');
    Flight::json($service->get_all());
});


Flight::route('GET /contacts/@id', function ($id) {
    $service = Flight::get('contacts_service');
    $contact = $service->get_by_id((int)$id);

    if ($contact) {
        Flight::json($contact);
    } else {
        Flight::halt(404, 'Contact not found');
    }
});


Flight::route('POST /contacts', function () {
    $service = Flight::get('contacts_service');
    $data = Flight::request()->data->getData();
    $created = $service->add($data);
    Flight::json($created, 201);
});
