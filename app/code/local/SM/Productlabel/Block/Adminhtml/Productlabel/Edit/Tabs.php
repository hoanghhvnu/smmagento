<?php

class SM_Productlabel_Block_Adminhtml_Productlabel_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
//      echo __METHOD__;
      parent::__construct();
      $this->setId('productlabel_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('productlabel')->__('Productlabel Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'title'     => Mage::helper('productlabel')->__('Productlabel Information'),
          'label'     => Mage::helper('productlabel')->__('General'),
          'content'   => $this->getLayout()->createBlock('productlabel/adminhtml_productlabel_edit_tab_form')->toHtml(),
      ));
//      $this->addTab('form_section2', array(
//          'title'     => Mage::helper('productlabel')->__('Manage Images'),
//          'label'     => Mage::helper('productlabel')->__('Images'),
//          'content'   => $this->getLayout()->createBlock('productlabel/adminhtml_imageproductlabel_edit_tab_form')->toHtml(),
//      ));
     
      return parent::_beforeToHtml();
  }
}