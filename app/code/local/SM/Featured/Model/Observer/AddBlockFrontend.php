<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 10/2/14
 * Time: 11:12 PM
 */

/**
 * Use to add Block Featured product to frontend, instead of use xml layout file
 * Class SM_Featured_Model_Observer_AddBlockFrontend
 */
class SM_Featured_Model_Observer_AddBlockFrontend
{
    const HOME_PAGE_ACTION = 'cms_index_index';
    const CATEGORY_PAGE_ACTION = 'catalog_category_view';

    public function addBlockFeatured(Varien_Event_Observer $observer)
    {
        $moduleStatus = Mage::getStoreConfig('sm_featured/sm_featured/enable');
        $homeStatus = Mage::getStoreConfig('sm_featured/home/enable_home');
        $categoryStatus = Mage::getStoreConfig('sm_featured/category/enable_category');
        if ($moduleStatus) {
            $action = $observer->getEvent()->getAction();
            $fullActionName = $action->getFullActionName();
            $layout = $observer->getEvent()->getLayout();

            if ($fullActionName == self::HOME_PAGE_ACTION ) {
                if ($homeStatus) {
                    $layout->getUpdate()->addUpdate($this->_generateBlockXml(self::HOME_PAGE_ACTION));
                    $layout->generateXml();
                }
            } elseif ($fullActionName == self::CATEGORY_PAGE_ACTION) {
                if ($categoryStatus) {
                    $layout->getUpdate()->addUpdate($this->_generateBlockXml(self::CATEGORY_PAGE_ACTION));
                    $layout->generateXml();
                }
            } // end if
        } // end if enable module

    } // end method add
    
    protected function _generateBlockXml($pageAction = '')
    {
        $position = '';
        if ($pageAction){
            $group = ($pageAction == self::HOME_PAGE_ACTION) ? 'home' : 'category';
            $positionConfig = Mage::getStoreConfig('sm_featured/' . $group);

            if ($positionConfig[$group . '_before_after'] && $positionConfig[$group . '_block_name']) {
                $position = $positionConfig[$group . '_before_after'] . '="';
                if ($positionConfig[$group . '_block_name'] == 'custom'){
                    $position .= $positionConfig[$group . '_block_name_other'] . '"';
                } else {
                    $position .= $positionConfig[$group . '_block_name'] . '"';
                } // end if = custom
            } // end if isset psition
        } // end if page action



        $featuredXml = '<reference name="content">'
                    . '<block type="featured/featured"
                        name="show.featured.product"
                        template="featured/featured.phtml" '
                    . $position .  ' />'
                    . '</reference>';
        return $featuredXml;
    } // end method _generateXML
} // end class
// end file