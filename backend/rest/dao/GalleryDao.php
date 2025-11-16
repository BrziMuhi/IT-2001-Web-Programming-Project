<?php

require_once __DIR__ . '/BaseDao.php';

class GalleryDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('gallery');
    }

    public function get_by_tour(int $tour_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM gallery WHERE tour_id = :tour_id"
        );
        $stmt->execute(['tour_id' => $tour_id]);
        return $stmt->fetchAll();
    }
}

?>
