<?php

/**
 * SuperiorService data helper
 */
namespace Techievolve\SuperiorService\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    const SUPERIORSERVICE_ENABLED     = 'superiorservice/settings/enabled';
    const SUPERIORSERVICE_CUSTOMER     = 'superiorservice/settings/customers';
    const SUPERIORSERVICE_PRODUCT_REVIEWS  = 'superiorservice/settings/product_reviews';
    const SUPERIORSERVICE_ELIQUID_FLAVOURS     = 'superiorservice/settings/eliquid_flavors';
    const SUPERIORSERVICE_VAPE_PRODUCTS     = 'superiorservice/settings/vape_products';
    
    
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
        return abs((int)$this->_scopeConfig->getValue(self::SUPERIORSERVICE_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
    
    /**
     * Return total number of customers counted and set by cron
     * @return int
     */
    
    public function getCustomerCount()
    {
        return abs((int)$this->_scopeConfig->getValue(self::SUPERIORSERVICE_CUSTOMER, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
    
    
    /**
     * Return total number of product reviews counted and set by cron
     * @return int
     */
    
    public function getProductReviews()
    {
        return abs((int)$this->_scopeConfig->getValue(self::SUPERIORSERVICE_PRODUCT_REVIEWS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
    
    
    /**
     * Return total number of eliquid flavors counted and set by cron
     * @return int
     */
    
    public function getEliquidFlavors()
    {
        return abs((int)$this->_scopeConfig->getValue(self::SUPERIORSERVICE_ELIQUID_FLAVOURS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
    
    /**
     * Return total number of vape products counted and set by cron
     * @return int
     */
    
    public function getVapeProducts()
    {
        return abs((int)$this->_scopeConfig->getValue(self::SUPERIORSERVICE_VAPE_PRODUCTS, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
    }
    
    
    /*
     * Format number
     * @param integer $number
     * @return string $thecash
    */
    
    
    public function formatNumber($number) {
        $explrestunits = "" ;
        if(strlen($number)>3) {
            $lastthree = substr($number, strlen($number)-3, strlen($number));
            $restunits = substr($number, 0, strlen($number)-3); 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits;
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++) {
                // creates each of the 2's group and adds a comma to the end
                if($i==0) {
                    $explrestunits .= (int)$expunit[$i].","; 
                } else {
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $number;
        }
        return $thecash; 
    }
    
    
    
    
}
