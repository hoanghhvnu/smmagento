<?php
class SM_Slider_Block_Slider extends Mage_Core_Block_Template
//class SM_Slider_Block_Slider extends Mage_Page_Block_Html_Head
{
    public function __construct() {
//        echo __METHOD__;
        return parent::__construct();
    }
	public function _prepareLayout()
    {
        
//        echo __METHOD__;
        $sliderStatus = Mage::getStoreConfig('sm_slider/sm_slider/show');

        if ($sliderStatus == 1) {
            $blockHead = Mage::app()->getLayout()->getBlock('head');
            Mage::app()->getLayout()->getBlock('head')->addItem('skin_css', 'css/slider/lib/idangerous.swiper.css');
            $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/slider/lib/idangerous.swiper.js');
//            $blockHead->addItem('skin_js','js/runslider.js','defer');
        }

		return parent::_prepareLayout();
    } // end _prepareLayout()


    /**
     * show only one slider, so must choose one to show
     * @return False if not config or not valid
     * @return int id if it's valid
     */
    public function getActiveSliderId() {
        $activeSliderId = Mage::getStoreConfig('sm_slider/sm_slider/active_slider');
        if ($activeSliderId == NULL || ! ctype_digit($activeSliderId)) {
            return FALSE;
        } // end if
        return $activeSliderId;
    } // end method getActiveSliderId()

    /**
     * get Array image for slider will be show
     * @return array
     */
    public function getImagesForSlider() {
        $sliderId = $this->getActiveSliderId();
        if ($sliderId == NULL) {
            return FALSE;
        }
        $imageCollection = Mage::getModel('slider/imageslider')
            ->getCollection()
            ->addFieldToFilter('slider_id',array('eq'=> $sliderId))
            ->setOrder('sortorder','ASC');
        ;
        return $imageCollection;
    } // end method getSliderInfo

} // end class
// end file