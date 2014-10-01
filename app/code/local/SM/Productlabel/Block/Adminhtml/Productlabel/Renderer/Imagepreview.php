<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/10/14
 * Time: 11:38 AM
 */
class Sm_Productlabel_Block_Adminhtml_Productlabel_Renderer_Imagepreview
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
         /* Render Grid Column*/
    public function render(Varien_Object $row){
//        var_dump($row);
//        die();

        if($row->getImageName())
            return sprintf('
                <a href="%s">%s</a>',
                Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'/images/productlabel/'.$row->getImageName(),
                '<img alt="" src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)
                .'/images/productlabel/'.$row->getImageName().'"  />'
            );
    }
}