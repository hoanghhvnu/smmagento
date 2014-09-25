<?php

class SM_Slider_Block_Adminhtml_Imageslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('imageslider_form', array('legend'=>Mage::helper('slider')->__('Item information')));
     
      $title = $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('slider')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $imageName = $fieldset->addField('imagename', 'file', array(
//      $imageName = $fieldset->addField('imagename', 'image', array(
          'label'     => Mage::helper('slider')->__('Image'),
//          'class'     => 'required-entry',
//          'required'  => true,
          'name'      => 'imagename',
      ));

      $sortorder = $fieldset->addField('sortorder', 'text', array(
          'label'     => Mage::helper('slider')->__('Sort order'),
          'name'      => 'sortorder',
      ));

      $description = $fieldset->addField('description', 'textarea', array(
          'label'     => Mage::helper('slider')->__('Description'),
          'name'      => 'description',
      ));

      $sliderId = $fieldset->addField('slider_id', 'select', array(
          'label'     => Mage::helper('slider')->__('Slider'),
          'name'      => 'slider_id',
          'values'    => $this->getListSlider(),
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


      if ( Mage::getSingleton('adminhtml/session')->getImagesliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getImagesliderData());
          Mage::getSingleton('adminhtml/session')->setImagesliderData(null);
      } elseif ( Mage::registry('imageslider_data') ) {
          $form->setValues(Mage::registry('imageslider_data')->getData());
      }


      return parent::_prepareForm();
  }

    /**
     * get all slider to select
     */
    public function getListSlider(){
        $sliderCollection = Mage::getModel('slider/slider')
            ->getCollection()
        ;
//        echo "<pre>";
//        var_dump($sliderCollection->getData());
        $resultArray = array();
        foreach ($sliderCollection as $slider){
            $temp = array();
            if($slider['status'] == 2){
                continue;
            }
            $temp['label'] = $slider['title'];
            $temp['value'] = $slider['slider_id'];
            $resultArray[] = $temp;
        } // end foreach
        return $resultArray;
    } // end method getListSlider
} // end class
// end file