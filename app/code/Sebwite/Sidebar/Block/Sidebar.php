<?php namespace Sebwite\Sidebar\Block;

use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Model\ResourceModel\Product;
use Magento\Framework\View\Element\Template;

/**
 * Class:Sidebar
 * Sebwite\Sidebar\Block
 *
 * @author      Sebwite
 * @package     Sebwite\Sidebar
 * @copyright   Copyright (c) 2015, Sebwite. All rights reserved
 */
class Sidebar extends Template
{

    /**
     * @var \Magento\Catalog\Helper\Category
     */
    protected $_categoryHelper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Catalog\Model\Indexer\Category\Flat\State
     */
    protected $categoryFlatConfig;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection */
    protected $_productCollectionFactory;
	
    /** @var \Magento\Catalog\Helper\Output */
    private $helper;
	
	protected $_categoryModel;
	
	protected $_filterProvider;
	protected $_storeManager;
	protected $_blockFactory;
	
    /**
     * @param Template\Context                                        $context
     * @param \Magento\Catalog\Helper\Category                        $categoryHelper
     * @param \Magento\Framework\Registry                             $registry
     * @param \Magento\Catalog\Model\Indexer\Category\Flat\State      $categoryFlatState
     * @param \Magento\Catalog\Model\CategoryFactory                  $categoryFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollectionFactory
     * @param \Magento\Catalog\Helper\Output                          $helper
     * @param array                                                   $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\ResourceModel\Product\Collection $productCollectionFactory,
        \Magento\Catalog\Helper\Output $helper,
		\Sebwite\Sidebar\Helper\Data $dataHelper,
		\Magento\Catalog\Model\Category $categoryModel,
		\Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        $data = [ ]
    )
    {
        $this->_categoryHelper           = $categoryHelper;
        $this->_coreRegistry             = $registry;
        $this->categoryFlatConfig        = $categoryFlatState;
        $this->_categoryFactory          = $categoryFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->helper                    = $helper;
		$this->_dataHelper 				 = $dataHelper;
		$this->_categoryModel 			 = $categoryModel;
		$this->_filterProvider = $filterProvider;
        $this->_storeManager = $storeManager;
        $this->_blockFactory = $blockFactory;

        parent::__construct($context, $data);
    }
	
    /*
    * Get owner name
    * @return string
    */
	
    /**
     * Get all categories
     *
     * @param bool $sorted
     * @param bool $asCollection
     * @param bool $toLoad
     *
     * @return array|\Magento\Catalog\Model\ResourceModel\Category\Collection|\Magento\Framework\Data\Tree\Node\Collection
     */
    public function getCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        $cacheKey = sprintf('%d-%d-%d-%d', $this->getSelectedRootCategory(), $sorted, $asCollection, $toLoad);
        if ( isset($this->_storeCategories[ $cacheKey ]) )
        {
            return $this->_storeCategories[ $cacheKey ];
        }

        /**
         * Check if parent node of the store still exists
         */
        $category = $this->_categoryFactory->create();
		
		$categoryDepthLevel = $this->_dataHelper->getCategoryDepthLevel();

        $storeCategories = $category->getCategories($this->getSelectedRootCategory(), $recursionLevel = $categoryDepthLevel, $sorted, $asCollection, $toLoad);

        $this->_storeCategories[ $cacheKey ] = $storeCategories;

        return $storeCategories;
    }

    /**
     * getSelectedRootCategory method
     *
     * @return int|mixed
     */
    public function getSelectedRootCategory()
    {
        $category = $this->_scopeConfig->getValue(
            'sebwite_sidebar/general/category'
        );

		if ( $category == 'current_category_children'){
			$currentCategory = $this->_coreRegistry->registry('current_category');
			if($currentCategory){
				return $currentCategory->getId();
			}
			return 1;
		}
		
		if ( $category == 'current_category_parent_children'){
			$currentCategory = $this->_coreRegistry->registry('current_category');
			if($currentCategory){
				$topLevelParent = $currentCategory->getPath();
				$topLevelParentArray = explode("/", $topLevelParent);
				if(isset($topLevelParent)){
					return $topLevelParentArray[2];
				}
			}
			return 1;
		}		
		
        if ( $category === null )
        {
            return 1;
        }

        return $category;
    }

    /**
     * @param        $category
     * @param string $html
     * @param int    $level
     *
     * @return string
     */
    public function getChildCategoryView($_category, $html = '', $level = 1)
    {
		$category = $this->_categoryModel->load($_category->getId());
        // Check if category has children
        if ( $category->hasChildren() )
        {

            $childCategories = $this->getSubcategories($category);
            if ( count($childCategories) > 0 )
            {

                $html .= '<ul class="cd-secondary-dropdown ejuice-child-menu is-hidden">';
				$html .= '<li class="go-back"><a href="javascript:void(0)">'.$category->getName().'</a></li>';
				$html .= '<li class="has-children">
							<a class="meghamneu-name" href="'.$this->getCategoryUrl($_category).'">'.$category->getName().'</a>
							<ul class="ejuice-child-cat is-hidden">';
							
							$html .= '<li class=""><a href="'.$this->getCategoryUrl($_category).'">'.__('All '.$category->getName()).'</a></li>';
							
						// Loop through children categories
								foreach ( $childCategories as $childCategory )
								{
									
									$html .= '<li class="level' . $level . ($this->isActive($childCategory) ? ' active' : '') . ($childCategory->hasChildren() ? ' has-children' : '').'">';
									$html .= '<a href="' . $this->getCategoryUrl($childCategory) . '" title="' . $childCategory->getName() . '" class="meghamneu-name ' . ($this->isActive($childCategory) ? 'is-active' : '') . '">' . $childCategory->getName() . '</a>';
				
									if ( $childCategory->hasChildren() ){						
										$html .= $this->getChildSubCategoryView($childCategory, '', ($level + 1));
									}
				
									$html .= '</li>';
								}
						$html .= '</ul>';
						
						if($category->getMegamenuDisplayType()!='' && $category->getMegamenuDisplayType()!=\Techievolve\CategoryTab\Helper\Data::MEGAMENU_BLOCK_TYPE_NONE){
							
							if($category->getMegamenuDisplayType()==\Techievolve\CategoryTab\Helper\Data::MEGAMENU_BLOCK_TYPE_STATIC_BLOCK){								
								$html .= $this->getStaticBlock($category->getMegamenuBlock());								
							}
							
							if($category->getMegamenuDisplayType()==\Techievolve\CategoryTab\Helper\Data::MEGAMENU_BLOCK_TYPE_DEAL_PRODUCT){								
								//$html .= $this->getStaticBlock($category->getMegamenuBlock());								
							}
							
						}
						
						$html .= '</li>';
                $html .= '</ul>';
            }
        }

        return $html;
    }
	
	
	
	/**
     * @param        $category
     * @param string $html
     * @param int    $level
     *
     * @return string
     */
    public function getChildSubCategoryView($_category, $html = '', $level = 2)
    {
		$category = $this->_categoryModel->load($_category->getId());
        // Check if category has children
        if ( $category->hasChildren() )
        {

            $childCategories = $this->getSubcategories($category);
            if ( count($childCategories) > 0 )
            {

                switch($level){
					
					case 2:
						$clsLevel = 'ejuice-brand-list ';
						break;
					default:
						$clsLevel = '';					
					
				}				
				
                $html .= '<ul class="'.$clsLevel.' is-hidden">';
				
				if($level>=2){
					$html .= '<li class="go-back"><a href="javascript:void(0)">'.$category->getName().'</a></li>';
				}
                // Loop through children categories
                foreach ( $childCategories as $childCategory ){
                    $html .= '<li class="level' . $level . ($this->isActive($childCategory) ? ' active' : '') . ($childCategory->hasChildren() ? ' has-children' : '').'">';
                    $html .= '<a href="' . $this->getCategoryUrl($childCategory) . '" title="' . $childCategory->getName() . '" class="' . ($this->isActive($childCategory) ? 'is-active' : '') . '">' . $childCategory->getName() . '</a>';
					
                    if ( $childCategory->hasChildren() ){
						if($level==2){
							$html .= '<a class="meghamneu-name" href="javascript:void(0)">'.$category->getName().'</a>';
						}
                        $html .= $this->getChildSubCategoryView($childCategory, '', ($level + 1));
                    }
					
                    $html .= '</li>';
                }
                $html .= '</ul>';
            }
        }

        return $html;
    }
	
	

    /**
     * Retrieve subcategories
     * DEPRECATED
	 *
     * @param $category
     *
     * @return array
     */
	 
    public function getSubcategories($category)
    {
		$category = $this->_categoryModel->load($category->getId());
        if ( $this->categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource() )
        {
            return (array)$category->getChildrenNodes();
        }

        return $category->getChildrenCategories();
    }
	

    /**
     * Get current category
     *
     * @param \Magento\Catalog\Model\Category $category
     *
     * @return Category
     */
    public function isActive($category)
    {
        $activeCategory = $this->_coreRegistry->registry('current_category');
        $activeProduct  = $this->_coreRegistry->registry('current_product');

        if ( !$activeCategory )
        {

            // Check if we're on a product page
            if ( $activeProduct !== null )
            {
                return in_array($category->getId(), $activeProduct->getCategoryIds());
            }

            return false;
        }

        // Check if this is the active category
        if ( $this->categoryFlatConfig->isFlatEnabled() && $category->getUseFlatResource() AND
            $category->getId() == $activeCategory->getId()
        )
        {
            return true;
        }

        // Check if a subcategory of this category is active
        $childrenIds = $category->getAllChildren(true);
        if ( !is_null($childrenIds) AND in_array($activeCategory->getId(), $childrenIds) )
        {
            return true;
        }

        // Fallback - If Flat categories is not enabled the active category does not give an id
        return (($category->getName() == $activeCategory->getName()) ? true : false);
    }

    /**
     * Return Category Id for $category object
     *
     * @param $category
     *
     * @return string
     */
    public function getCategoryUrl($category)
    {
        return $this->_categoryHelper->getCategoryUrl($category);
    }
	
	
	public function getStaticBlock($blockId){
        $html = '';
        if ($blockId) {
            $storeId = $this->_storeManager->getStore()->getId();
            /** @var \Magento\Cms\Model\Block $block */
            $block = $this->_blockFactory->create();
            $block->setStoreId($storeId)->load($blockId);

                $html = $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent());
        }
        return   $html;
	}
	
	
}
