<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/BookingsDao.php';

class BookingsService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new BookingsDao());
    }

    public function get_by_user($user_id)
    {
        return $this->dao->get_by_user($user_id);
    }

    public function get_by_tour($tour_id)
    {
        return $this->dao->get_by_tour($tour_id);
    }
}
