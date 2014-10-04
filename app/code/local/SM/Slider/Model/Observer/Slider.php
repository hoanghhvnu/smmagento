<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 10/4/14
 * Time: 9:07 PM
 */
class SM_Slider_Model_Observer_Slider
{
    const HOME_PAGE_ACTION = 'cms_index_index';
    const CATEGORY_PAGE_ACTION = 'catalog_category_view';

    public function addBlockSlider(Varien_Event_Observer $observer)
    {
//        echo __METHOD__;
        $arrCurrentHandle = $observer->getLayout()->getUpdate()->getHandles();
//        Zend_debug::dump($arrCurrentHandle);

        $sliders = Mage::getModel('slider/slider')
            ->getCollection()
            ->addFieldToFilter('status', array('eq' => 1))
            ->addFieldToFilter('handle', array('in' => $arrCurrentHandle))
        ;
        if ($sliders->count() > 0) {
//            Zend_debug::dump($sliders->getData());
            $layout = $observer->getEvent()->getLayout();
            foreach ($sliders as $slider) {
                $position = '';
                if ($slider->getBeforeAfter() && $slider->getBlockName()) {
                    $position = $slider->getBeforeAfter() . '="' . $slider->getBlockName() . '"';
//                    Zend_debug::dump($position);
                } // end if position
                $thisBlockName = 'show.slider.' . $slider->getSliderId();
                $sliderBlockInfo = array(
                    'name' => $thisBlockName,
                    'position' => $position,
                );
//                Mage::unregister('slider_id_from_observer');
//                Mage::register('slider_id_from_observer', $slider->getSliderId());
//                $registerid =  Mage::registry('slider_id_from_observer');
//                    Zend_debug::dump($registerid);
                $layout->getUpdate()->addUpdate($this->_generateBlockXml($sliderBlockInfo));
                $layout->generateXml();
//                Zend_debug::dump($this->_generateBlockXml($sliderBlockInfo));
            }// end foreach
//            die();
        } // end if getCount
    } // end method add
    protected function _generateBlockXml(array $blockInfo)
    {
        $sliderXml = '<reference name="content">'
            . '<block type="slider/slider"
                        name="' . $blockInfo['name'] . '" '
                        . ' template="slider/showslider.phtml" '
            . $blockInfo['position'] .  ' />'
            . '</reference>';
        return $sliderXml;
    } // end method _generateXML
} // end class
// end file