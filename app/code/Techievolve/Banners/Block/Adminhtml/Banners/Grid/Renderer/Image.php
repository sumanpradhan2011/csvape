<?php

namespace Techievolve\Banners\Block\Adminhtml\Banners\Grid\Renderer;

use Magento\Framework\DataObject;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    protected $_storeManager;
    protected $_helper;
    protected $_banner;
    public function __construct(
            \Magento\Store\Model\StoreManagerInterface $storeManager,
            \Techievolve\Banners\Helper\Data $_helper,
            \Techievolve\Banners\Model\BannersFactory $banner
        )
    {
           $this->_storeManager = $storeManager;
           $this->_helper = $_helper;
           $this->_banner = $banner;
    }
    
    public function render(DataObject $row)
    {
        $bannerId = $row->getData($this->getColumn()->getIndex());
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $bannersItem = $this->_banner->create();
        $bannersItem->load($bannerId);
        $imageUrl = $this->_helper->resize($bannersItem,150,100);
        
        return '<img src="'.$imageUrl.'" alt="'.$bannersItem->getTitle().'" />';
    }
}