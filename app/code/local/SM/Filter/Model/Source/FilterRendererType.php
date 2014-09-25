<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/25/14
 * Time: 9:38 AM
 */
class SM_Filter_Model_Source_FilterRendererType
{
    const DEFAULT_TYPE  = 0;
    const CHECKBOX_TYPE = 1;
    const LINK_TYPE     = 2;
    const SELECT_TYPE   = 3;
    const COLOR_TYPE    = 4;


    public function toOptionArray()
    {
        return array(
            array('value' => self::DEFAULT_TYPE, 'label' => 'Default'),
            array('value' => self::CHECKBOX_TYPE, 'label' => 'Checkbox'),
            array('value' => self::LINK_TYPE, 'label' => 'Link'),
            array('value' => self::SELECT_TYPE, 'label' => 'Select'),
            array('value' => self::COLOR_TYPE, 'label' => 'Color'),
        );
    }
} // end class
// end file