<?php

namespace Techievolve\PopularCategory\Block;

class Category extends \Magento\Framework\View\Element\Template {
    public $_coreRegistry;
    public $_helper;
    public $_csvapeHelper;
    public $_categoryCollectionFactory;
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Techievolve\PopularCategory\Helper\Data $_helper,
        \Techievolve\Csvape\Helper\Data $_csvapeHelper,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $_categoryCollectionFactory,
        \Magento\Catalog\Helper\Category $categoryHelper,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_helper = $_helper;
        $this->_csvapeHelper = $_csvapeHelper;
        $this->_categoryCollectionFactory = $_categoryCollectionFactory;
        $this->_categoryHelper = $categoryHelper;
        parent::__construct($context, $data);
    }
    
     /**
     * Get category collection
     *
     * @param bool $isActive
     * @param bool|int $level
     * @param bool|string $sortBy
     * @param bool|int $pageSize
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection or array
     */
    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');  
        $collection->addAttributeToFilter('is_popular',1);
        
        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }
                
        // select categories of certain level
        if ($level) {
            $collection->addLevelFilter($level);
        }
        
        // sort categories by some value
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }
        
        // select certain number of categories
        if ($pageSize) {
            $collection->setPageSize($pageSize); 
        }    
        
        return $collection;
    }
    
    
    /**
     * Retrieve current store categories
     *
     * @param bool|string $sorted
     * @param bool $asCollection
     * @param bool $toLoad
     * @return \Magento\Framework\Data\Tree\Node\Collection or
     * \Magento\Catalog\Model\ResourceModel\Category\Collection or array
     */
    
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted = false, $asCollection = false, $toLoad = true);
    }
    
    
    
    /*
     * Resize Images
     * @return string
     */
    
    public function resizeImage($image,$absolutePathDir,$width = null, $height = null){
        return $this->_csvapeHelper->resizeImage($image,$absolutePathDir,$width, $height);
    }
    
    
    /*
	 * Get No Image Url
	 * @return string
	 */
	
	public function getNoImageUrl(){
		return $this->_helper->getMediaUrl().'catalog/no_image.jpg';
	}
    
       
    
}
?>