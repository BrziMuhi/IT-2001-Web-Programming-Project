<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/ContactsDao.php';

class ContactsService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new ContactsDao());
    }
}

?>