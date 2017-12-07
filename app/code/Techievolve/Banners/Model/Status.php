<?php

namespace Techievolve\Banners\Model;

/**
 * Status Model
 *
 * @method \Techievolve\Banners\Model\Resource\Page _getResource()
 * @method \Techievolve\Banners\Model\Resource\Page getResource()
 */
class Status extends \Magento\Framework\Model\AbstractModel
{
    
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;
    
    public function getStatusArray(){
       
        return array(
               array(
                   'value'     => self::STATUS_ENABLED,
                   'label'     => __('Enabled'),
               ),  
               array(
                   'value'     => self::STATUS_DISABLED,
                   'label'     => __('Disabled'),
               ),
           );
       
    }
   
   
    public static function getOptionArray()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    
}
