<?php

/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/18/14
 * Time: 8:40 AM
 */
class SM_Bestseller_Block_Bestseller extends Mage_Catalog_Block_Product_New
{
    const LIMIT_BESTSELLER_PRODUCT = 5;

    protected $_productCount;
    /**
     * Retrieve Bestseller product to show in frontend
     * @return mixed
     */
    public function myBest()
    {
        $storeId = Mage::app()->getStore()->getId();

        $handleArray = Mage::app()->getLayout()->getUpdate()->getHandles();
        $categoryHandle = 'catalog_category_view';

        $sourceConfig = Mage::getStoreConfig('sm_bestseller/sm_bestseller_source');
        if ($sourceConfig && ! empty($sourceConfig) ){
            $sourceType = $sourceConfig['timeperiod'];
            $date = new Zend_Date();
            /**
             * Select time range to retrive bestseller
             */
            if ($sourceType && $sourceType == 'specify') {
                $fromDate = $date->setDate($sourceConfig['fromdate'] )->get('Y-MM-dd');
                $toDate = $date->setDate($sourceConfig['todate'] )->get('Y-MM-dd');
            } else {
                /**
                 * use switch to return begin of week, month, year...
                 */
                switch ($sourceType) {
                    case 'subWeek':
                        $toDate = $date->subDay(
                            $date->getDate()->get('e') ) // return day of week in digit
                            ->getDate()
                            ->get('Y-MM-dd')
                        ;
                        break;
                    case 'subMonth':
                        $toDate = $date
                            ->setDay(1)
//                            ->subDay(
//                            $date->getDate()->get('dd') ) // return day of month in digit
                            ->getDate()
                            ->get('Y-MM-dd')
                        ;
                        break;
                    case 'subYear':
                        $toDate = $date->subDay(
                            $date->getDate()->get('D') ) // return day of year in digit
                            ->getDate()
                            ->get('Y-MM-dd')
                        ;
                        break;
                    default :
                        $toDate = $date->getDate()
                            ->get('Y-MM-dd')
                        ;
                } // end switch

                $subType = $sourceType;
                $unit = ($sourceConfig['unit']) ? $sourceConfig['unit'] : 1;
                $fromDate = $date->$subType($unit)->getDate()->get('Y-MM-dd');

            } // end else
            /**
             * Limit maximum product retrieve
             */
            $limit = $sourceConfig['limitproduct'];
            if ($limit > 0 && ctype_digit($limit)) {
                $this->setProductsCount($limit);
            }

            $products = Mage::getResourceModel('reports/product_collection')
                ->addOrderedQty($fromDate, $toDate) // filter by range of time
//            ->addOrderedQty()
                ->addAttributeToSelect('*')
                ->addAttributeToSelect(array('name', 'price', 'small_image'))
                ->setStoreId($storeId)
                ->addStoreFilter($storeId)
                ->setOrder('ordered_qty', 'desc'); // most best sellers on top
            Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
            Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);

            $products->setPageSize($limit)
                     ->setCurPage(1)
            ;
            if (in_array($categoryHandle, $handleArray)) {
                $categoryId = Mage::getModel('catalog/layer')->getCurrentCategory()->getId();
                $categoryModel = Mage::getModel('catalog/category')->load($categoryId);
                $products->addCategoryFilter($categoryModel);
            }

            return $products;
        } // end if sourceconfig
    } // end myBest()


    public function _prepareLayout()
    {
        $bestsellerStatus = Mage::getStoreConfig('sm_featured/sm_bestseller/enable');
        if ($bestsellerStatus == 1) {
            Mage::app()->getLayout()->getBlock('head')->addItem('skin_css', 'css/slider/lib/idangerous.swiper.css');
            $this->getLayout()->getBlock('head')->addItem('skin_js', 'js/slider/lib/idangerous.swiper.js');
        }

        return parent::_prepareLayout();
    } // end _prepareLayout()

    public function getProductCount()
    {
        if (is_null($this->_productsCount)) {
            return self::LIMIT_BESTSELLER_PRODUCT;
        } else {
            return $this->_productsCount;
        }
    } // end getProductCount

    public function setProductCount($value = '')
    {
        if ($value && ctype_digit($value)) {
            $this->_productsCount = $value;
        }
        return TRUE;
    } // end setProductCount
} // end class
// end file