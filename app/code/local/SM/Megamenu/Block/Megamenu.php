<?php
class SM_Megamenu_Block_Megamenu extends Mage_Core_Block_Template
{
    const CATEGORY_LINK_TYPE = 1;
    const CUSTOM_LINK_TYPE   = 2;
    const BLOCK_LINK_TYPE    = 3;

    public function __construct() {
        return parent::__construct();

    }
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

    public function getMegaItem() {
        $megaCollection = Mage::getModel('megamenu/megamenu')
            ->getCollection()
            ->addFieldToFilter('status',array('eq'=>1))
            ->setOrder('position','ASC')
        ;

        $listItem = array();
        foreach ($megaCollection as $item) {
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
                    $itemValue = $item['link'];
                    continue;
            } // end switch

            $listItem[] = array(
                'title'    => $item['title'],
                'type'     => $item['type'],
                'value'    => $itemValue,
                'position' => $item['position'],
            );
        } // end foreach
        return $listItem;
    } // end getMegaItem

    public function createBlockLink($blockId='') {
        $contentBlock = '';
        if ($blockId) {
            $blockModel = Mage::getModel('cms/block')->load($blockId);
            $contentBlock = $blockModel->getContent();
        } // end if
        return $contentBlock;
    } // end createCategoryLink

    public function createCategoryLink($title='', $categoryId='') {
        $maxDepth = Mage::getStoreConfig('sm_megamenu/sm_megamenu/level');
        if ( ($maxDepth == 0) || (! ctype_digit($maxDepth) )) $maxDepth = NULL;
        $link = '';
        if ($title && $categoryId) {
            $link .= $this->getChildrenCategory($categoryId, $maxDepth);
            return $link;
        }
    } // end createCategoryLink


    /**
     * Retrieve category
     *
     */
    public function getChildrenCategory($categoryRootId = '', $maxDepth = NULL, $surroundElement = '', $surroundHasChilderen ='')
    {
        $currentDepth = 0;
        $result = '';
        $categoryRootId = trim($categoryRootId);

        if ($categoryRootId != '' && ctype_digit($categoryRootId)){
            $rootCategory = Mage::getModel('catalog/category')->load($categoryRootId);
            $rootPath = $rootCategory->getPath();

            if ($rootPath != '') {
                $result .= '<li class="category-link" category-id=' . $categoryRootId . '>';
                $result .=  '<a href="' . Mage::getBaseUrl() . $rootCategory->getUrlPath() . '">'
                        .  $rootCategory->getName() . '</a>';

                if ( (is_null($maxDepth) || ($currentDepth < $maxDepth) ) && $rootCategory->hasChildren()) {
                    $currentDepth++;
                    $childrenCollection = Mage::getModel('catalog/category')
                        ->getCollection()
                        ->addAttributeToSelect('name')
                        ->addAttributeToSelect('url_path')
//                    ->addAttributeToFilter('entity_id', array('neq' => $categoryRootId)) // not include root Category
                        ->addAttributeToFilter('path', array('like' => $rootPath . '/' . '%'))
                    ;
                    $categoryCollection = array();
                    foreach ($childrenCollection as $child) {
                            $categoryCollection[] = $child->getData();
                    } // end foreach

                    $result .= $this->myRecursive($rootCategory->getData(), $currentDepth, $maxDepth, $categoryCollection);
                }// end if hasChildren
                $result .= '</li>';
            }
            return $result;
        } // end if
    } // end method get

    public function myRecursive($categoryRootData = NULL, $currentDepth = NULL, $maxDepth = NULL, &$categoryCollection)
    {
        $result = '';
        if (! is_null($categoryRootData) && ! empty($categoryRootData)){
            $rootId = $categoryRootData['entity_id'];
            if ( (! is_null($currentDepth) && (is_null($maxDepth) || $currentDepth < $maxDepth)
                && count($categoryCollection) > 0)
            ) {
//                echo count($categoryCollection) . '-';
                $currentDepth++;
                $validChild = array();
                foreach ($categoryCollection as $key => $child) {
                    if ($child['parent_id'] == $rootId ) {
                        $validChild[$key] = $child;
                    }
                } // end foreach
                if (count($validChild) > 0){
                    $result .= '<ul class="level' . $currentDepth . '">';
                    foreach ($validChild as $key => $child) {
                        unset($categoryCollection[$key]);
                    }
                    $i = 0;
                    $lastPosition = count($validChild) - 1;
                    foreach ($validChild as $child) {
                        $additionClass = array();
                        if ($i == 0) {
                            $additionClass[] = 'first-child';
                        } elseif ($i == $lastPosition) {
                            $additionClass[] = 'last-child';
                        }

                        $childrenContent = $this->myRecursive($child, $currentDepth, $maxDepth, $categoryCollection);
                        if ($childrenContent != '') {
                            $additionClass[] = 'has-children';
                        }
//                        $additionClass[] = 'category-id=' . $child['entity_id'];

                        $result .= '<li class="level' . $currentDepth . ' ' . implode(' ', $additionClass)
                             .  '" ' . ' category-id=' . $child['entity_id'] . '>';
                        $result .=  '<a href="' . Mage::getBaseUrl() .  $child['url_path'] . '">' . $child['name'] . '</a>';
//                        $result .= $this->myRecursive($child, $currentDepth, $maxDepth, $categoryCollection);
                        $result .= $childrenContent;
                        $result .= '</li>';
                        $i++;
                    } // end foreach $validChild
                    $result .= '</ul>';
                } // end if count valid child
            } // end if valid depth
        } // end if
        return $result;
    } // end method myRecursive



} // end file