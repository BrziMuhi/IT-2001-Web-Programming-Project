<?php

require_once __DIR__ . '/rest/dao/UsersDao.php';
require_once __DIR__ . '/rest/dao/ToursDao.php';

echo "<pre>";

echo "TESTING DATABASE CONNECTION\n";

try {
    $usersDao = new UsersDao();
    $toursDao = new ToursDao();

    
    echo "\n=== USERS LIST ===\n";
    $users = $usersDao->get_all();
    print_r($users);

    echo "\n=== TOURS LIST ===\n";
    $tours = $toursDao->get_all();
    print_r($tours);

    
    echo "\n=== INSERT TEST USER ===\n";
    $newUser = $usersDao->insert([
        'name'          => 'Test User',
        'email'         => 'testuser@example.com',
        'password_hash' => 'test123',
        'phone'         => null,
        'role'          => 'user'
    ]);
    print_r($newUser);

    echo "\n\nALL GOOD ✔️\n";

} catch (Throwable $e) {   
    echo "ERROR : " . $e->getMessage();
}

echo "</pre>";
