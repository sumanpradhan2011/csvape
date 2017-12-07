<?php

/**
 * Csvape data helper
 */
namespace Techievolve\Csvape\Helper;

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
	 * Resize Images with custom width and height
	 */
	
	public function resizeImage($image,$absolutePathDir,$width = null, $height = null)
    {
        $absolutePath = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath($absolutePathDir).$image;

        $imageResized = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath($absolutePathDir.'resized/'.$width.'/').$image;
        //create image factory...
        $imageResize = $this->_imageFactory->create();         
        $imageResize->open($absolutePath);
        $imageResize->constrainOnly(TRUE);         
        $imageResize->keepTransparency(TRUE);         
        $imageResize->keepFrame(FALSE);         
        $imageResize->keepAspectRatio(TRUE);         
        $imageResize->resize($width,$height);  
        //destination folder                
        $destination = $imageResized ;    
        //save image      
        $imageResize->save($destination);         

        $resizedURL = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).$absolutePathDir.'resized/'.$width.'/'.$image;
        return $resizedURL;
	} 
	
}
