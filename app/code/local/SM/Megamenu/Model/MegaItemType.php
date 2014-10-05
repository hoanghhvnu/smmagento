<?php

class SM_Megamenu_Model_MegaItemType extends Varien_Object
{
    const CATEGORY_LINK_TYPE = 1;
    const CUSTOM_LINK_TYPE   = 2;
    const BLOCK_LINK_TYPE    = 3;

    static public function getOptionArray()
    {
        return array(
            self::CATEGORY_LINK_TYPE   => Mage::helper('megamenu')->__('Category link'),
            self::CUSTOM_LINK_TYPE    => Mage::helper('megamenu')->__('Custom link'),
            self::BLOCK_LINK_TYPE   => Mage::helper('megamenu')->__('Block link'),
        );
    }
}