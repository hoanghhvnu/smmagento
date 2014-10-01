<?php

class SM_Productlabel_Block_Adminhtml_Productlabel_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
//        echo __METHOD__;
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'productlabel';
        $this->_controller = 'adminhtml_productlabel';
        
        $this->_updateButton('save', 'label', Mage::helper('productlabel')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('productlabel')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productlabel_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productlabel_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productlabel_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('productlabel_data') && Mage::registry('productlabel_data')->getId() ) {
            return Mage::helper('productlabel')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('productlabel_data')->getTitle()));
        } else {
            return Mage::helper('productlabel')->__('Add Item');
        }
    }
}