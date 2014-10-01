<?php

class SM_Productlabel_Block_Adminhtml_Productlabel_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
//      echo __METHOD__;
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('productlabel_form', array('legend'=>Mage::helper('productlabel')->__('Label information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('productlabel')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));

      $fieldset->addField('imagename', 'file', array(
//      $imageName = $fieldset->addField('imagename', 'image', array(
          'label'     => Mage::helper('productlabel')->__('Image'),
//          'class'     => 'required-entry',
//          'required'  => true,
          'name'      => 'imagename',
      ));

      $fieldset->addField('position', 'select',
          array(
              'label'     => Mage::helper('productlabel')->__('Position'),
              'class'     => 'required-entry',
              'required'  => true,
              'name'      => 'position',
              'values'    => Mage::Helper('productlabel/retrievelabel')->getPositionArray(),
          )
      );

      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('productlabel')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('productlabel')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('productlabel')->__('Disabled'),
              ),
          ),
      ));


      if ( Mage::getSingleton('adminhtml/session')->getProductlabelData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductlabelData());
          Mage::getSingleton('adminhtml/session')->setProductlabelData(null);
      } elseif ( Mage::registry('productlabel_data') ) {
          $form->setValues(Mage::registry('productlabel_data')->getData());
      }
      return parent::_prepareForm();
  }

} // end class
// end file