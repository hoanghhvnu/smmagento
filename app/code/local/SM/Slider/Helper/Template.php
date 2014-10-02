<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/12/14
 * Time: 4:56 PM
 */
class SM_Slider_Helper_Template{
    public function choose(){
        $sliderType = Mage::getStoreConfig('sm_slider/sm_slider/type');
        if($sliderType == ''){
            return FALSE;
        }
        switch($sliderType){
            case 'dynamic' :
                return 'slider/showslider.phtml';
                break;
            case 'activecenter':
                return 'slider/centeractiveslider.phtml';
                break;
        }
    } // end choose
}