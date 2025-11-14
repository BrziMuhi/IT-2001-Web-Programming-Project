<?php

require_once __DIR__ . '/BaseDao.php';

class ContactsDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('contacts');
    }

    public function get_by_user(int $user_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM contacts WHERE user_id = :user_id ORDER BY created_at DESC"
        );
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }
}
