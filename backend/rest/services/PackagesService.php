<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/PackagesDao.php';

class PackagesService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new PackagesDao());
    }

    public function get_active()
    {
        return $this->dao->get_active();
    }
}
