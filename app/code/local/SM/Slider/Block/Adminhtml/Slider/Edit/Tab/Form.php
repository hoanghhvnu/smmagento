<?php

class SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
//      echo __METHOD__;
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('slider')->__('Item information')));
     
      $title = $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('slider')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $handle = $fieldset->addField('handle', 'multiselect', array(
          'label'     => Mage::helper('slider')->__('Apply page'),
          'name'      => 'handle',
          'class'     => 'require-entry',

          'require'   => true,
          'values'   => Mage::getModel('slider/source_somehandle')->toOptionArray()
      ));

      $sliderType = Mage::getModel('slider/slidertype')->toOptionArray();
      array_unshift($sliderType, array('value'=>'', 'label'=>''));
      $typeShow = $fieldset->addField('type_show', 'select', array(
          'label'     => Mage::helper('slider')->__('Type show'),
          'name'      => 'type_show',
          'values'   => $sliderType,
      ));

      $beforeAfter = $fieldset->addField('before_after', 'select', array(
          'label'     => Mage::helper('slider')->__('Position'),
          'name'      => 'before_after',
          'values'   => Mage::getModel('slider/source_preposition')->toOptionArray()
      ));

      $blockName = $fieldset->addField('block_name', 'select', array(
          'label'     => Mage::helper('slider')->__('Block name'),
          'name'      => 'block_name',
          'values'   => Mage::getModel('slider/source_blockname')->toOptionArray()
      ));

      $blockNameOther = $fieldset->addField('block_name_other', 'text', array(
          'label'     => Mage::helper('slider')->__('Block name other'),
          'name'      => 'block_name_other',
      ));

      $status = $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('slider')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('slider')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('slider')->__('Disabled'),
              ),
          ),
      ));


      if ( Mage::getSingleton('adminhtml/session')->getSliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSliderData());
          Mage::getSingleton('adminhtml/session')->setSliderData(null);
      } elseif ( Mage::registry('slider_data') ) {
          $form->setValues(Mage::registry('slider_data')->getData());
      }

      $this->setForm($form);
      $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
              ->addFieldMap($title->getHtmlId(), $title->getName())
              ->addFieldMap($handle->getHtmlId(), $handle->getName())
              ->addFieldMap($typeShow->getHtmlId(), $typeShow->getName())
              ->addFieldMap($beforeAfter->getHtmlId(), $beforeAfter->getName())
              ->addFieldMap($blockName->getHtmlId(), $blockName->getName())
              ->addFieldMap($blockNameOther->getHtmlId(), $blockNameOther->getName())
              ->addFieldMap($status->getHtmlId(), $status->getName())



              ->addFieldDependence(
                  $blockName->getName(),
                  $beforeAfter->getName(),
                  array('before', 'after')
              )
              ->addFieldDependence(
                  $blockNameOther->getName(),
                  $blockName->getName(),
                  'other'
              )
      );

      return parent::_prepareForm();
  }

} // end class
// end file