<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ToursDao.php';

class ToursService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new ToursDao());
    }

    public function get_active()
    {
        return $this->dao->get_active();
    }
}
