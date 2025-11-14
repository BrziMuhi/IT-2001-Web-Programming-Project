<?php

require_once __DIR__ . '/BaseDao.php';

class BookingsDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('bookings');
    }

    public function get_by_user(int $user_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT b.*, t.title AS tour_title
             FROM bookings b
             JOIN tours t ON b.tour_id = t.id
             WHERE b.user_id = :user_id
             ORDER BY b.created_at DESC"
        );
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function get_by_tour(int $tour_id): array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM bookings WHERE tour_id = :tour_id ORDER BY created_at DESC"
        );
        $stmt->execute(['tour_id' => $tour_id]);
        return $stmt->fetchAll();
    }
}
