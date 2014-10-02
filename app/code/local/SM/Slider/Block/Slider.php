<?php
class SM_Slider_Block_Slider extends Mage_Core_Block_Template
{
    public function __construct() {
        return parent::__construct();
    }
	public function _prepareLayout()
    {
        $sliderStatus = Mage::getStoreConfig('sm_slider/sm_slider/show');
        if ($sliderStatus == 1) {
            $blockHead = Mage::app()->getLayout()->getBlock('head');
            $blockHead->addItem('skin_css', 'css/slider/lib/idangerous.swiper.css');
            $blockHead->addItem('skin_js', 'js/slider/lib/idangerous.swiper.js');

            $sliderType = Mage::getStoreConfig('sm_slider/sm_slider/type');
            if ($sliderType == 'dynamic') {
                $blockHead->addItem('skin_css', 'css/slider/slider_dynamic.css');
            } elseif ($sliderType == 'activecenter') {
                $blockHead->addItem('skin_css', 'css/slider/slider_activecenter.css');
            }

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