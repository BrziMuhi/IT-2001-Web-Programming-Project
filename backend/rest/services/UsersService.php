<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UsersDao.php';

class UsersService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new UsersDao());
    }

    private function sanitize_user(array $user): array
    {
        unset($user['password_hash']);
        return $user;
    }

    public function login(string $email, string $password): array
    {
        $user = $this->dao->get_by_email($email);

        if (!$user || $user['password_hash'] !== $password) {
            Flight::halt(401, 'Invalid email or password');
        }

        return $this->sanitize_user($user);
    }
}

?>