<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/25/14
 * Time: 9:35 AM
 */
class SM_Filter_Model_Observer_FilterObserver
{
    /**
     * add Field to change type of filter in admin edit tab
     * @param Varien_Event_Observer $observer
     */
    public function addField(Varien_Event_Observer $observer)
    {
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

    /**
     * Change template file of filter
     * @param Varien_Event_Observer $observer
     */
    public function changeFilterTemplate(Varien_Event_Observer $observer)
    {
        if (Mage::getStoreConfig('sm_filter/sm_filter/enable')) {
            $block = $observer->getBlock();
            if ($block instanceof Mage_Catalog_Block_Layer_View) {
                $listChild = $block->getChild();
                foreach ($listChild as $child) {
                    if  ($child->getType() == 'catalog/layer_filter_attribute'
                        || $child->getType() == 'catalog/layer_filter_price'
                    ) {
                        $child->setTemplate('catalog/layer/otherfilter.phtml');
                    }

                }
            } // end if
        } // end if enable module

    } // end method changeFilterTemplate()
} // end class
// end file