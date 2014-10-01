<?php

class SM_Productlabel_Model_Mysql4_Productlabel extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the web_id refers to the key field in your database table.
        $this->_init('productlabel/productlabel', 'label_id');
    }
}