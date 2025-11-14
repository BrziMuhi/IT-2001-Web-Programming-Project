<?php

require_once __DIR__ . '/BaseDao.php';

class UsersDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function get_by_email(string $email): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }
}
