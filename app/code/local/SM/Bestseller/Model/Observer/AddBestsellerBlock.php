<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/24/14
 * Time: 4:33 PM
 */
class SM_Bestseller_Model_Observer_AddBestsellerBlock {
    public function addBestseller(Varien_Event_Observer $observer) {
        $block = $observer->getBlock('content');
        $bestsellerStatus = Mage::getStoreConfig('sm_bestseller/sm_bestseller/enable');
        if ($bestsellerStatus) {
            $bestBlock = $block->append();
        }

    } // end method addBestseller
} // end class
// end file