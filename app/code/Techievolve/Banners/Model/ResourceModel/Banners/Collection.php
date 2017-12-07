<?php

/**
 * Banners Resource Collection
 */
namespace Techievolve\Banners\Model\ResourceModel\Banners;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Techievolve\Banners\Model\Banners', 'Techievolve\Banners\Model\ResourceModel\Banners');
    }
}
