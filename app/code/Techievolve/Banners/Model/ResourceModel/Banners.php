<?php

namespace Techievolve\Banners\Model\ResourceModel;

/**
 * Banners Resource Model
 */
class Banners extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('te_banners', 'banners_id');
    }
}
