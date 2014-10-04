<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 10/4/14
 * Time: 1:26 AM
 */
class SM_Slider_Model_Source_SomeHandle
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'cms_index_index', 'label' => 'Home page'),
            array('value' => 'catalog_category_view', 'label' => 'All category page'),
        );
    } // end method

    protected function collectData()
    {

    } // end method
} // end class
// end file