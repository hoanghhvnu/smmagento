<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 10/3/14
 * Time: 10:30 PM
 */
class SM_Featured_Model_Source_PrePosition
{
    public function toOptionArray()
    {
        return array(
            array('value' => '', 'label' => Mage::helper('adminhtml')->__('Default') ),
            array('value' => 'before', 'label' => Mage::helper('adminhtml')->__('Before') ),
            array('value' => 'after', 'label' => Mage::helper('adminhtml')->__('After') ),
        );
    }
} // end class
// end file