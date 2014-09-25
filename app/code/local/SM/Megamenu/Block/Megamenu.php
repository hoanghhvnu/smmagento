<?php
class SM_Megamenu_Block_Megamenu extends Mage_Core_Block_Template
{
    const CATEGORY_LINK_TYPE = 1;
    const CUSTOM_LINK_TYPE   = 2;
    const BLOCK_LINK_TYPE    = 3;

    public function __construct() {
//        echo __METHOD__;
        return parent::__construct();
    }
	public function _prepareLayout()
    {
//        $blockHead = Mage::app()->getLayout()->getBlock('head');
//        $blockHead->addItem('skin_js','js/jquery-1.10.2.min.js');
		return parent::_prepareLayout();
    }
    


    public function getMegaItem() {
        $megacollection = Mage::getModel('megamenu/megamenu')
            ->getCollection()
            ->addFieldToFilter('status',array('eq'=>1))
            ->setOrder('position','ASC')
            ->getData()
        ;
        $listItem = array();
        foreach ($megacollection as $item) {
            switch($item['type']) {
                case self::CATEGORY_LINK_TYPE :
                    $itemValue = $item['category_id'];
                    break;
                case self::CUSTOM_LINK_TYPE :
                    $itemValue = $item['link'];
                    break;
                case self::BLOCK_LINK_TYPE :
                    $itemValue = $item['static_block_id'];
                    break;
                default:
                    continue;
            } // end switch

            $temp = array(
                'title'    => $item['title'],
                'type'     => $item['type'],
                'value'    => $itemValue,
                'position' => $item['position'],
            );
            $listItem[] = $temp;
        } // end foreach
        return $listItem;
    } // end getMegaItem


    public function showCategory($categoryId='', $isRoot='') {
//        echo __METHOD__;
//        die();
        $cateDetail = Mage::getModel('catalog/category')
            ->load($categoryId);
        $result = '';

        if ($isRoot != TRUE) {
            $result .= "<li" . " " . 'category_id = ' . $categoryId . ">"
                    . "<a href='" . Mage::getBaseUrl() . $cateDetail['url_path'] . "'>"
//                  .$categoryId
                    . $cateDetail['name'] . "</a>";
        }

        if ($cateDetail->hasChildren() === TRUE) {
            if ($isRoot != TRUE) {
                $result .= "<ul>";
            }

            $childIdString = $cateDetail->getChildren();
            $childIdArray = explode(',', $childIdString);
            foreach ($childIdArray as $childId) {
                $result .= $this->showCategory($childId);
            }
            if ($isRoot != TRUE) {
                $result .= "</ul>";
            }

        }
        if ($isRoot != TRUE) {
            $result .= "</li>";
        }

        return $result;
    } // end showCategory()

    public function createCustomLink($title = "", $customLink= '') {
        $link = '';
        if ($title && $customLink) {
            $link .= "<a href='" . $customLink . "'>";
            $link .= $title;
            $link .= "</a>";
        } // end if

        return $link;
    } // end createCustomLink

    public function createBlockLink($title='', $blockId='') {
        $link = '';
        if ($title && $blockId) {
            $blockModel = Mage::getModel('cms/block')
                ->load($blockId)
            ;
            $link .= $title;
            $link .= "<ul>";
            $link .= "<li>";
            $link .= $blockModel->getContent();
            $link .= "</li>";
            $link .= "</ul>";
        } // end if
        return $link;
    } // end createCategoryLink

    public function createCategoryLink($title='', $categoryId='') {
        $cateDetail = Mage::getModel('catalog/category')
            ->load($categoryId);
        $link = '';
        if ($title && $categoryId) {
            $link .= "<a href='" . Mage::getBaseUrl() . $cateDetail['url_path'] ."'>";
//            $link .= "(" . $categoryId .  ")";
            $link .= $title;
            $link .= "</a>";
            $link .= "<ul id = 'catelink'>";
//            $link .= $this->showCategory($categoryId, TRUE);
            $link .= $this->showCategory($categoryId, TRUE);
            $link .= "</ul>";
            return $link;

        }
    } // end createCategoryLink

    public function getRawCategory() {
        // get category
        $cateCollection = Mage::getModel('catalog/category')
//            ->load(4);
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('url_path')
//        ->addAttributeToSelect('name')
        ;
//        echo "<pre>";
//        print_r($cateCollection
//            ->getData()
//        );
        $listCate = array();
        foreach ($cateCollection as $cate) {
//            var_dump($cate->getData());
            $id = $cate->getId();
            $parent = $cate->getParentId();
            $position = $cate->getPosition();
            $name = $cate->getName();
            $path = $cate->getUrlPath();
//            var_dump($path);
            $item = array();
            $item['cate_id'] = $id;
            $item['cate_name'] = $name;
            $item['cate_parent'] = $parent;
            $item['cate_order'] = $position;
            $item['url_path'] = $path;
            $listCate[] = $item;
        }

//        echo "<pre>";
//        var_dump($listCate);
//        die();
        return $listCate;

    } // end method getCategory()
    //Hoanghh

    public function getCategory($levelSign = "") {
        echo __METHOD__;
//        $sequenceList = $this->cate_model->getAll();
        $sequenceList = $this->getRawCategory();
        if ( empty($sequenceList)) {
            echo "Have no category!";
        } else{
            // get Category level 0, ParentId = 0;
            $strLevel = "";
            $sortedList = $this->recursive(0, $sequenceList, $strLevel);
            return $sortedList;
        } // end if empty
    } // end getCategory


    /**
     * written by HoangHH
     * Use to get sub-level category, support for listcate() method
     * @param  [type] $parentId
     * @param  [type] $list
     * @param  [type] $strLevel
     * @return [type]
     */
    private function recursive($parentId, &$list, $strLevel) {
        echo __METHOD__;
        if ( ! empty($list)) {
            if ( $parentId != 0 ) {
//                $strLevel .= "____";
                $strLevel = "";
            } else{
                // $strLevel = "";
            }

            $levelList = array();

            foreach ($list as $key => $cateDetail) {
                if ($parentId == $cateDetail['cate_parent']) {
                    $temp = array(
                        'cate_id' => $cateDetail ['cate_id'],
                        'cate_name' => $strLevel . $cateDetail ['cate_name'],
                        'cate_parent' => $cateDetail ['cate_parent'],
                        'cate_order' => $strLevel . $cateDetail ['cate_order'],
                        'url_path' => $cateDetail['url_path']
                    );
                    $levelList[$key] = $temp;
                    // $levelList[$key] = $cateDetail;
                    unset($list[$key]);
                } // end if ParentId
            } // end foreach $list



            if ( ! empty($levelList)) {
                $levelSortByOrder = array();
                foreach ($levelList as $key => $levelCateDetail) {
                    $levelKeyOrder[$key] = $levelCateDetail['cate_order'];
                }

                asort($levelKeyOrder);

                $levelSorted = array();
                foreach ($levelKeyOrder as $key => $cateOrder) {
                    $levelSorted[$key] = $levelList[$key];
                }

                $levelAndSub = array();
                foreach ($levelSorted as $key => $levelCateDetail) {
                    $levelAndSub[] = $levelCateDetail;
                    $subLevel = $this->recursive($levelCateDetail['cate_id'], $list, $strLevel);
                    if ( ! empty($subLevel)) {
                        foreach ($subLevel as $key => $subLevelCateDetail) {
                            $levelAndSub[] = $subLevelCateDetail;
                        }
                    } // end if SubLevel
                } // end foreach LevelSorted
                return $levelAndSub;
            } // end if empty $level
        } // end if ! empty()
    } // end recursive()
}