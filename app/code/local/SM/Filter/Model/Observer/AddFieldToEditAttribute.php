<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/25/14
 * Time: 9:35 AM
 */
class SM_Filter_Model_Observer_AddFieldToEditAttribute
{
    public function addField(Varien_Event_Observer $observer)
    {
//        echo __METHOD__;
        $fieldset = $observer->getForm()->getElement('base_fieldset');
        $filterType = Mage::getModel('filter/source_filterrenderertype')->toOptionArray();
        array_unshift($filterType, array('label' => '', 'value' => ''));
        $fieldset->addField('filter_frontend_renderer_type', 'select',
            array(
                'name' => 'filter_frontend_renderer_type',
                'label' => Mage::helper('catalog')->__('Filter frontend renderer type'),
                'title' => Mage::helper('catalog')->__('Filter frontend renderer type'),
                'values' => $filterType,
             )
        );
    } // end method addField()
} // end class
// end file