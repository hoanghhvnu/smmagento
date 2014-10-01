<?php

class SM_Productlabel_Model_Mysql4_Productlabel_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productlabel/productlabel');
    }
}