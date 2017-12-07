<?php

namespace Techievolve\SuperiorService\Block;

/**
 * SuperiorService content block
 */
class SuperiorService extends \Magento\Framework\View\Element\Template
{
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Techievolve\SuperiorService\Helper\Data $dataHelper,
        array $data = []
    ) {
        $this->_dataHelper = $dataHelper;
        parent::__construct(
            $context,
            $data
        );
    }
    
    
    /*
     * Get Customer Count
     * @return int
    */
    
    public function getCustomerCount(){
        
        $customerCount = $this->_dataHelper->getCustomerCount();        
        return $this->_dataHelper->formatNumber($customerCount);
    }
    
    /*
     * Get Reviews Count
     * @return int
    */
    
    public function getReviewsCount(){
        $reviewsCount = $this->_dataHelper->getProductReviews();
        return $this->_dataHelper->formatNumber($reviewsCount);
    }
    
    /*
     * Get Eliquid Flavors Count
     * @return int
    */
    
    public function getEliquidFlavorsCount(){
        $eliquidFlavors = $this->_dataHelper->getEliquidFlavors();
        return $this->_dataHelper->formatNumber($eliquidFlavors);
    }
    
    
    /*
     * Get Vape Products Count
     * @return int
    */
    
    public function getVapeProductsCount(){
        $vapeProducts = $this->_dataHelper->getVapeProducts();
        return $this->_dataHelper->formatNumber($vapeProducts);
    }
    
    
}
