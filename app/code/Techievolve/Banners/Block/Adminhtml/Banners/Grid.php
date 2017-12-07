<?php
namespace Techievolve\Banners\Block\Adminhtml\Banners;

/**
 * Adminhtml Banners grid
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Techievolve\Banners\Model\ResourceModel\Banners\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Techievolve\Banners\Model\Banners
     */
    protected $_banners;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Techievolve\Banners\Model\Banners $bannersPage
     * @param \Techievolve\Banners\Model\ResourceModel\Banners\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Techievolve\Banners\Model\Banners $banners,
        \Techievolve\Banners\Model\ResourceModel\Banners\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_banners = $banners;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('bannersGrid');
        $this->setDefaultSort('banners_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        /* @var $collection \Techievolve\Banners\Model\ResourceModel\Banners\Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        
        $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
        $statusModel = $objectManager->create('Techievolve\Banners\Model\Status');
        
        $this->addColumn('banners_id', [
            'header'    => __('ID'),
            'index'     => 'banners_id',
        ]);
        
        
        $this->addColumn('image', [
            'header'    => __('Image'),
            'index'     => 'banners_id',
            'filter' => false,
            'renderer' => 'Techievolve\Banners\Block\Adminhtml\Banners\Grid\Renderer\Image'
        ]);
        
        
        $this->addColumn('title', ['header' => __('Title'), 'index' => 'title']);
        
        $this->addColumn(
            'status',            
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' =>  $statusModel->getOptionArray()
            ]);
        
        
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created'),
                'index' => 'created_at',
                'type' => 'datetime',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );
        
        $this->addColumn(
            'action',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'banners_id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['banners_id' => $row->getId()]);
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
