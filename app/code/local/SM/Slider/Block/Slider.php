<?php
class SM_Slider_Block_Slider extends Mage_Core_Block_Template
{
    protected $_sliderClass;

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
        } // end if enable module

		return parent::_prepareLayout();
    } // end _prepareLayout()


    /**
     * get id should be shown
     *
     * @return int id if it's valid
     */
    public function getActiveSliderId() {
        $arrSliderIdForRequestHandle = $this->getSliderByPage();
        $arrSliderId = $arrSliderIdForRequestHandle;
        if ( ! empty($arrSliderId)) {
            $sliderId = '';
            if (count($arrSliderId) == 1) {
                $sliderId = $arrSliderId[0];
            } elseif (count($arrSliderId) > 1) {
                $beforeSessionId = Mage::registry('showed_slider_id_key');
                if (is_null($beforeSessionId) ) {
                    Mage::register('showed_slider_id_key', 0);
                    $sliderId = $arrSliderId[0];
                } else {
                    Mage::unregister('showed_slider_id_key');
                    Mage::register('showed_slider_id_key', $beforeSessionId + 1);
                    $sliderId = $arrSliderId[$beforeSessionId + 1];
                    if ( ($beforeSessionId + 1) == (count($arrSliderId) - 1) ) {
                        Mage::unregister('showed_slider_id_key');
                    } // end if unregister
                } // end if is_null
            } // end if assign slider id
            $this->_sliderClass = 'slider' . $sliderId;
            return $sliderId;
        } // end if empty
    } // end method getActiveSliderId()

    /**
     * get Array image for slider will be show
     * @return array
     */
    public function getImagesForSlider()
    {
        $sliderId = $this->getActiveSliderId();
        if ($sliderId) {
            $imageCollection = Mage::getModel('slider/imageslider')
                ->getCollection()
                ->addFieldToFilter('slider_id',array('eq'=> $sliderId))
                ->setOrder('sortorder','ASC');
            ;
            return $imageCollection;
        } // end if
    } // end method getSliderInfo

    /**
     * get all slider id which should be showed in request handle
     * @return array of ids
     */
    public function getSliderByPage()
    {
        $arrCurrentHandle = $this->getLayout()->getUpdate()->getHandles();
        $sliders = Mage::getModel('slider/slider')
            ->getCollection()
            ->addFieldToSelect('slider_id')
            ->addFieldToFilter('status', array('eq' => 1))
            ->addFieldToFilter('handle', array('in' => $arrCurrentHandle))
        ;
        if ($sliders->count() > 0) {
            $arrId = array();
            foreach ($sliders as $slider) {
                $arrId[] = $slider->getSliderId();
            }
            return $arrId;
        } // end if getCount
    } // end method getSlider

    public function getSliderClass()
    {
        return $this->_sliderClass;
    }

//    public function getSliderConfig()
//    {
//        $sliderType = Mage::getStoreConfig('sm_slider/sm_slider/type');
//
//        $allSliderConfig = Mage::getStoreConfig('sm_slider/sm_slider');
//        $autoPlayTime    = isset($allSliderConfig['autoplay']) ? $allSliderConfig['autoplay'] : 5000;
//        $speedAnimation  = isset($allSliderConfig['speedanimate']) ? $allSliderConfig['speedanimate'] : 300;
//        $mode            = isset($allSliderConfig['mode']) ? $allSliderConfig['mode'] : 'horizontal';
//        $slidePerView    =  1;
//
//        if ($sliderType == 'activecenter'){
//            $slidePerView = isset($allSliderConfig['slideperview']) ? $allSliderConfig['slideperview'] : 3;
//        }
//
//        return array(
//            'autoplay' => $autoPlayTime,
//            'speed'    => $speedAnimation,
//            'mode'     => $mode,
//            'slidesPerView' => $slidePerView,
//        );
//    }// end method getSliderConfig
} // end class
// end file