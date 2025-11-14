<?php

require_once __DIR__ . '/BaseDao.php';

class ToursDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('tours');
    }

    public function get_active(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM tours WHERE active = 1");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function get_by_guide(int $guide_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM tours WHERE guide_id = :guide_id"
        );
        $stmt->execute(['guide_id' => $guide_id]);
        return $stmt->fetchAll();
    }
}
