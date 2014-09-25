<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/10/14
 * Time: 4:55 PM
 */
class SM_Slider_Model_ListEnableSlider{
    public function getListSlider(){
        $sliderCollection = Mage::getModel('slider/slider')
            ->getCollection()
        ;
        $sliderArray = array();
        foreach ($sliderCollection as $slider){
            if($slider['status'] == 2){ // if it's Disable
                continue;
            }
            if($slider['status'] == 1){
                $temp = array(
                    'label' => $slider['title'],
                    'value' => $slider['slider_id']
                );
                $sliderArray[] = $temp;
            } // end if
        } // end foreach $sliderCollection
        return $sliderArray;
    } // end method getListSlider

    public function toOptionArray(){
        return $this->getListSlider();
    }
}