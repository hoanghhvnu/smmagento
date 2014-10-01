<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/18/14
 * Time: 10:57 AM
 */
class SM_Productlabel_Model_Source_ProductLabelType extends Mage_Eav_Model_Entity_Attribute_Source_Abstract{
    public function getAllOptions(){
        $productLabelCollection = Mage::getModel('productlabel/productlabel')
            ->getCollection()
        ;
        $result = array();
        foreach ($productLabelCollection as $item) {
            $result[] = array(
                'label' => $item->getName(),
                'value' => $item->getLabelId(),
            );
        }
        return $result;
//        return array(
//            array('value' => '', 'label' => Mage::helper('slider')->__('Select')), // not run, because 0== null
//            array('value' => '1', 'label' => Mage::helper('slider')->__('Second')),
//            array('value' => '2', 'label' => Mage::helper('slider')->__('Third')),
//        );
    } // end method getAllOption();
//


} // end class
// end file