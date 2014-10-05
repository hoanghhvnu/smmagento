<?php
class SM_Productlabel_Block_Adminhtml_Productlabel extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
//      echo __METHOD__;
    $this->_controller = 'adminhtml_productlabel';
    $this->_blockGroup = 'productlabel';
//      echo __METHOD__;
      $this->_headerText = Mage::helper('productlabel')->__('Productlabel Manager');

    $this->_addButtonLabel = Mage::helper('productlabel')->__('Add label');
    parent::__construct();
  }
}