<?php

/**
 * Csvape data helper
 */
namespace Techievolve\PopularCategory\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $httpFactory;
    
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
     
    protected $_instagramAccessToken;
	protected $_imageFactory;
	protected $_filesystem ;
     
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\HTTP\Adapter\FileTransferFactory $httpFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Filesystem $filesystem,         
        \Magento\Framework\Image\AdapterFactory $imageFactory 
    ) {
		
        $this->_scopeConfig = $scopeConfig;      
        $this->httpFactory = $httpFactory;        
        $this->_storeManager = $storeManager;
		$this->_filesystem = $filesystem;               
        $this->_imageFactory = $imageFactory; 
        
        parent::__construct($context);
    }
    
	
	/*
	 * Get Media Url
	 */
	
	public function getMediaUrl(){
		return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
	}
	
	/*
	 * Get Media Path
	 */
	
	public function getMediaPath(){
		return $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
	}
	
}
