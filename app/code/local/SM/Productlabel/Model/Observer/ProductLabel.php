<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 10/1/14
 * Time: 2:14 PM
 */
class SM_Productlabel_Model_Observer_ProductLabel
{
    public function addLabelToCollection(Varien_Event_Observer $observer)
    {
        $collection = $observer->getCollection()->addAttributeToSelect('product_label');;
    }// end method addLabelToCollection
} // end class
// end file