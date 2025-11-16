<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/GalleryDao.php';

class GalleryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new GalleryDao());
    }

    public function get_by_tour($tour_id)
    {
        $all = $this->dao->get_all();
        return array_values(array_filter($all, fn($g) => (int)$g['tour_id'] == $tour_id));
    }
}
