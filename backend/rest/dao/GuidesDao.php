<?php

require_once __DIR__ . '/BaseDao.php';

class GuidesDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('guides');
    }

    public function get_all_with_user(): array
    {
        $sql = "SELECT g.*, u.email AS user_email
                FROM guides g
                LEFT JOIN users u ON g.user_id = u.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
