<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UsersDao.php';

class UsersService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new UsersDao());
    }
}
