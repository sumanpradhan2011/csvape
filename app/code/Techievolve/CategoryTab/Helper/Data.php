<?php
/**
 * Copyright © 2015 Artis . All rights reserved.
 */
namespace Techievolve\CategoryTab\Helper;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	protected $_storeManager;
	protected $_priceModel;
	
	const MEGAMENU_BLOCK_TYPE_NONE = 0;
	const MEGAMENU_BLOCK_TYPE_STATIC_BLOCK = 1;
	const MEGAMENU_BLOCK_TYPE_DEAL_PRODUCT = 2;
	
	
	/**
     * @param \Magento\Framework\App\Helper\Context $context
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Store\Model\StoreManagerInterface $storeManager		
	) {
		parent::__construct($context);
		$this->_storeManager = $storeManager;
	}
	
	
	
}