<?php

/**
 * QuickAccess data helper
 */
namespace Techievolve\QuickAccess\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    const QUICKACCESS_ENABLED     = 'quickaccess/general/enabled';
    const FEATURED_PRODUCTS_ENABLED     = 'quickaccess/featuredproducts/enabled';
    const FEATURED_PRODUCTS_LIMIT     = 'quickaccess/featuredproducts/limit';
    
    
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_scopeConfig = $scopeConfig;       
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }
    
    
    /**
     * Return module enable or not
     * @return int
     */
    
    public function isEnabled()
    {
        return abs((int)$this->_scopeConfig->getValue(self::QUICKACCESS_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
    
    /**
     * Return featured Products enable or not
     * @return int
     */
    
    public function isFeaturedProductEnabled()
    {
        return abs((int)$this->_scopeConfig->getValue(self::FEATURED_PRODUCTS_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
    
    
    /**
     * Return number of limitation for feattured products
     * @return int
     */
    
    public function getFeaturedProductLimit()
    {
        return abs((int)$this->_scopeConfig->getValue(self::FEATURED_PRODUCTS_LIMIT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
    
    
}
