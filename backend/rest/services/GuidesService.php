<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/GuidesDao.php';

class GuidesService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new GuidesDao());
    }
}
