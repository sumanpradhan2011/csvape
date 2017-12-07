<?php

namespace Techievolve\Banners\Model;

/**
 * Banners Model
 *
 * @method \Techievolve\Banners\Model\Resource\Page _getResource()
 * @method \Techievolve\Banners\Model\Resource\Page getResource()
 */
class Banners extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Techievolve\Banners\Model\ResourceModel\Banners');
    }

}
