<?php

namespace Techievolve\Banners\Block;

/**
 * Banners content block
 */
class Banners extends \Magento\Framework\View\Element\Template
{
    /**
     * Banners collection
     *
     * @var Techievolve\Banners\Model\ResourceModel\Banners\Collection
     */
    protected $_bannersCollection = null;
    
    /**
     * Banners factory
     *
     * @var \Techievolve\Banners\Model\BannersFactory
     */
    protected $_bannersCollectionFactory;
    
    /** @var \Techievolve\Banners\Helper\Data */
    protected $_dataHelper;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Techievolve\Banners\Model\ResourceModel\Banners\CollectionFactory $bannersCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Techievolve\Banners\Model\ResourceModel\Banners\CollectionFactory $bannersCollectionFactory,
        \Techievolve\Banners\Helper\Data $dataHelper,
        array $data = []
    ) {
        $this->_bannersCollectionFactory = $bannersCollectionFactory;
        $this->_dataHelper = $dataHelper;
        parent::__construct(
            $context,
            $data
        );
    }
    
    /**
     * Retrieve banners collection
     *
     * @return Techievolve\Banners\Model\ResourceModel\Banners\Collection
     */
    protected function _getCollection()
    {
        $collection = $this->_bannersCollectionFactory->create();
        return $collection;
    }
    
    /**
     * Retrieve prepared banners collection
     *
     * @return Techievolve\Banners\Model\ResourceModel\Banners\Collection
     */
    public function getCollection()
    {
        if (is_null($this->_bannersCollection)) {
            $this->_bannersCollection = $this->_getCollection();
            $this->_bannersCollection->addFieldToFilter('status',1);
            $this->_bannersCollection->setOrder('created_at','asc');
        }

        return $this->_bannersCollection;
    }
    
        
    
    /**
     * Return URL for resized Banners Item image
     *
     * @param Techievolve\Banners\Model\Banners $item
     * @param integer $width
     * @return string|false
     */
    public function getImageUrl($item, $width)
    {
        return $this->_dataHelper->resize($item, $width);
    }
    
    
}
