<?php
/**
 * Adminhtml banners list block
 *
 */
namespace Techievolve\Banners\Block\Adminhtml;

class Banners extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_banners';
        $this->_blockGroup = 'Techievolve_Banners';
        $this->_headerText = __('Manage Banners');
        $this->_addButtonLabel = __('Add New Banner');
        parent::_construct();
        if ($this->_isAllowedAction('Techievolve_Banners::save')) {
            $this->buttonList->update('add', 'label', __('Add New Banner'));
        } else {
            $this->buttonList->remove('add');
        }
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
