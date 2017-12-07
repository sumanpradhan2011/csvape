<?php

namespace Techievolve\QuickAccess\Block;

/**
 * QuickAccess content block
 */
class QuickAccess extends \Magento\Framework\View\Element\Template
{
    
    protected $_products;
    protected $_collectionFactory;
    
    /** @var \Techievolve\QuickAccess\Helper\Data */
    protected $_dataHelper;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Techievolve\QuickAccess\Helper\Data $dataHelper,
        \Techievolve\QuickAccess\Block\Products $products,
        \Magento\Framework\Data\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_dataHelper = $dataHelper;
        $this->_products = $products;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct(
            $context,
            $data
        );
    }
    
    
    /*
     * Get Featured Product
     * @return \Magento\Catalog\Model\Product
    **/
    
    public function getFeaturedProduct(){
        
        $collection = $this->_products->getLoadedProductCollection();
        $collection->addAttributeToFilter('is_featured', 1);
        $collection->getSelect()
            ->order('rand()')
            ->limit(1);
        return $collection->getFirstItem();
        
    }
    
    
    /*
     * Get Top Eliquid Product
     * @return \Magento\Catalog\Model\Product
    **/
    
    public function getTopEliquidProduct(){
        
        $collection = $this->_products->getLoadedProductCollection();
        $collection->addAttributeToFilter('is_top_eliquid', 1);
        $collection->getSelect()
            ->order('rand()')
            ->limit(1);
        return $collection->getFirstItem();
        
    }
    
    /*
     * Get Top Devices Product
     * @return \Magento\Catalog\Model\Product
    **/
    
    public function getTopDevicesProduct(){
        
        $collection = $this->_products->getLoadedProductCollection();
        $collection->addAttributeToFilter('is_top_device', 1);
        $collection->getSelect()
            ->order('rand()')
            ->limit(1);
        return $collection->getFirstItem();
        
    }
    
    /*
     * Get New Arrival Products 
     * @return \Magento\Catalog\Model\Product
    **/
    
    public function getNewArrivals(){
        
        $todayStartOfDayDate = $this->_localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $todayEndOfDayDate = $this->_localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        
        
        $collection = $this->_products->getLoadedProductCollection();
        $collection->addStoreFilter()
                    ->addAttributeToFilter(
                        'news_from_date',
                        [
                            'or' => [
                                0 => ['date' => true, 'to' => $todayEndOfDayDate],
                                1 => ['is' => new \Zend_Db_Expr('null')],
                            ]
                        ],
                        'left'
                    )
                    ->addAttributeToFilter(
                        'news_to_date',
                        [
                            'or' => [
                                0 => ['date' => true, 'from' => $todayStartOfDayDate],
                                1 => ['is' => new \Zend_Db_Expr('null')],
                            ]
                        ],
                        'left'
                    )
                    ->addAttributeToFilter(
                        [
                            ['attribute' => 'news_from_date', 'is' => new \Zend_Db_Expr('not null')],
                            ['attribute' => 'news_to_date', 'is' => new \Zend_Db_Expr('not null')],
                        ]
                    )
                    ->addAttributeToSort('news_from_date','desc')
                    ->setPageSize(1)
                    ->setCurPage(1);
            
        return $collection->getFirstItem();
        
    }
    
    
    /*
     * Get Quick Access
     * @return \Magento\Catalog\Model\Product
    **/
    
    public function getQuickAccess(){
        
        $collection = $this->_collectionFactory->create();
        
        $varienObject = new \Magento\Framework\DataObject();        
        $varienObject->setData('featured_product',$this->getFeaturedProduct());
        $collection->addItem($varienObject);
        
        //$varienObject = new \Magento\Framework\DataObject();        
        //$varienObject->setData($this->getTopEliquidProduct());
        //$collection->addItem($varienObject);
        //
        //
        ////$varienObject = new \Magento\Framework\DataObject();        
        //$varienObject->setData($this->getTopDevicesProduct());
        //$collection->addItem($varienObject);
        
        return $collection;
    }
    
    
}
