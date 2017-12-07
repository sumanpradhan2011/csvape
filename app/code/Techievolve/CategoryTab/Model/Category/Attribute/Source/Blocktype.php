<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Techievolve\CategoryTab\Model\Category\Attribute\Source;;

/**
 * Catalog category landing page attribute source
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Blocktype extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['value' => \Techievolve\CategoryTab\Helper\Data::MEGAMENU_BLOCK_TYPE_NONE, 'label' => __('None')],
                ['value' => \Techievolve\CategoryTab\Helper\Data::MEGAMENU_BLOCK_TYPE_STATIC_BLOCK, 'label' => __('Static block')],
                ['value' => \Techievolve\CategoryTab\Helper\Data::MEGAMENU_BLOCK_TYPE_DEAL_PRODUCT, 'label' => __('Deal products')],
            ];
        }
              
        return $this->_options;
    }
}
