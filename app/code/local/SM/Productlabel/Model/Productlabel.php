<?php

class SM_Productlabel_Model_Productlabel extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productlabel/productlabel');
    }
}