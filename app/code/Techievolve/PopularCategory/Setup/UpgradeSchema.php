<?php

	namespace Techievolve\PopularCategory\Setup;
	

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
	
	/**
	 * @codeCoverageIgnore
	 */
	class UpgradeData implements UpgradeDataInterface {
		
		
		/**
		 * EAV setup factory
		 *
		 * @var EavSetupFactory
		 */
		private $eavSetupFactory;
	
		/**
		 * Init
		 *
		 * @param EavSetupFactory $eavSetupFactory
		 */
		public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
	{
			$this->eavSetupFactory = $eavSetupFactory;
	}
		
		
		
		
		/**
		 * {@inheritdoc}
		 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
		 */
		public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
		{
			
			
			if (version_compare($context->getVersion(), '1.0.1') < 0) {
				
				/** @var EavSetup $eavSetup */
				$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
				
				/**
				* Add attributes to the eav/attribute
				*/
				
			   $eavSetup->addAttribute(
				   \Magento\Catalog\Model\Category::ENTITY,
				   'thumb_image',
				   [
					   'group' => 'general',
					   'type' => 'varchar',
					   'label' => 'Thumbnail',
					   'input' => 'image',
					   'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
					   'sort_order' => 11,
					   'visible' => true,
					   'required' => false,
					   'user_defined' => true,
					   'default' => '',
					   'backend' => 'Techievolve\PopularCategory\Model\Category\Attribute\Backend\Thumb'
				   ]
			   );
			   
			   $setup->endSetup();
			   
			}
			   
			
		}
	}