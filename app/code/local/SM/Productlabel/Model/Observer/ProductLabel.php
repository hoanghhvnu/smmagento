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
//        die(__FILE__);
        $collection = $observer->getCollection()->addAttributeToSelect('product_label');;
//        $collection
//        echo "from observer";
//        foreach ($collection as $item) {
//
//            echo $item->getId(). '-';
//            Zend_debug::dump($item->getProductLabel());
//        }
//        Zend_debug::dump($collection->getData());
    }// end method addLabelToCollection
} // end class
// end file