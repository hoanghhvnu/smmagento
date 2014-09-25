<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/25/14
 * Time: 9:38 AM
 */
class SM_Filter_Model_Source_FilterRendererType
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => 'Checkbox'),
            array('value' => 2, 'label' => 'Link'),
            array('value' => 3, 'label' => 'Select'),
            array('value' => 4, 'label' => 'Color'),
        );
    }
} // end class
// end file