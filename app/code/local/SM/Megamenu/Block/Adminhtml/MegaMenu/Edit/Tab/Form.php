<?php

class SM_Megamenu_Block_Adminhtml_Megamenu_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
//      $this->getSortedCategory();
//      die();
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('megamenu_form', array('legend'=>Mage::helper('megamenu')->__('Item information')));
     
      $title = $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('megamenu')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $type = $fieldset->addField('type', 'select', array(
          'label'     => Mage::helper('megamenu')->__('Type'),
          'name'      => 'type',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('megamenu')->__('Category link'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('megamenu')->__('Custom link'),
              ),

              array(
                  'value'     => 3,
                  'label'     => Mage::helper('megamenu')->__('Block link'),
              ),
          ),
      ));

//      $fieldset->addField('filename', 'file', array(
//          'label'     => Mage::helper('megamenu')->__('File'),
//          'required'  => false,
//          'name'      => 'filename',
//	  ));
      $link = $fieldset->addField('link', 'text', array(
          'label'     => Mage::helper('megamenu')->__('Link'),
          'name'      => 'link',
      ));



      $staticBlockId = $fieldset->addField('static_block_id', 'select', array(
          'label'     => Mage::helper('megamenu')->__('Static Block'),
          'name'      => 'static_block_id',
          'values'    => $this->getListStaticBlock(),

      ));


      $categoryId = $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('megamenu')->__('Category link'),
          'name'      => 'category_id',
          'values'    => $this->getCategoryForForm(),

      ));


      $status = $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('megamenu')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('megamenu')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('megamenu')->__('Disabled'),
              ),
          ),
      ));

      $position = $fieldset->addField('position', 'text', array(
          'label'     => Mage::helper('megamenu')->__('Position'),

          'index' => 'position',
          'name'      => 'position',
      ));

//      $this->getRawCategory();
//      echo "<pre>";
//      print_r($this->getCategoryForForm());
     
      if ( Mage::getSingleton('adminhtml/session')->getMegamenuData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMegamenuData());
          Mage::getSingleton('adminhtml/session')->setMegamenuData(null);
      } elseif ( Mage::registry('megamenu_data') ) {
          $form->setValues(Mage::registry('megamenu_data')->getData());
      }

      $this->setForm($form);
      $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
              ->addFieldMap($title->getHtmlId(), $title->getName())
              ->addFieldMap($type->getHtmlId(), $type->getName())
              ->addFieldMap($link->getHtmlId(), $link->getName())
              ->addFieldMap($staticBlockId->getHtmlId(), $staticBlockId->getName())
              ->addFieldMap($categoryId->getHtmlId(), $categoryId->getName())
              ->addFieldMap($status->getHtmlId(), $status->getName())
              ->addFieldMap($position->getHtmlId(), $position->getName())

              ->addFieldDependence(
                  $link->getName(),
                  $type->getName(),
                  '2'
              )
              ->addFieldDependence(
                  $categoryId->getName(),
                  $type->getName(),
                  '1'
              )
              ->addFieldDependence(
                  $staticBlockId->getName(),
                  $type->getName(),
                  '3'
              )
      );
      return parent::_prepareForm();
  }

  public function getListStaticBlock(){
      // get all cms/block
      $collection = Mage::getModel('cms/block')
          ->getCollection()
          ->addFieldToSelect('block_id')
          ->addFieldToSelect('title')
          ->addFieldToSelect('identifier');
      $listStaticBlock = array();
      foreach ($collection as $block){
          $listStaticBlock[] = array(
              'value' => $block->getBlockId(),
              'label' => $block->getTitle() . " (identifier: " . $block->getIdentifier() . ")",
          );
      } // end foreach $collection
      return $listStaticBlock;
  } // end method gitListStaticBlock()


    public function getCategoryForForm(){
        $raw = $this->getCategory();
        $list = array();
        foreach ($raw as $cate){
            $list[] = array(
                'value' => $cate['cate_id'],
                'label' => $cate['cate_name'],
            );
        }
        return $list;
    }
    public function getRawCategory(){
        $catecollection = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
        ;
        $listCate = array();
        foreach ($catecollection as $cate){
            $listCate[] = array(
                'cate_id' =>  $cate->getId(),
                'cate_name' =>  $cate->getName(),
                'cate_parent' =>  $cate->getParentId(),
                'cate_order' =>  $cate->getPosition(),
            );
        } // end forearch
        return $listCate;
    } // end method getCategory()

    private function getCategory($levelSign = ""){
       $sequenceList = $this->getRawCategory();
        if( empty($sequenceList)){
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
    private function recursive($parentId, &$list, $strLevel){
        if( ! empty($list)){
            if( $parentId != 0 ){
                $strLevel .= "____";
            } else{
                // $strLevel = "";
            }

            $levelList = array();

            foreach ($list as $key => $cateDetail) {
                if($parentId == $cateDetail['cate_parent']){
                    $temp = array(
                        'cate_id' => $cateDetail ['cate_id'],
                        'cate_name' => $strLevel . $cateDetail ['cate_name'],
                        'cate_parent' => $cateDetail ['cate_parent'],
                        'cate_order' => $strLevel . $cateDetail ['cate_order']
                    );
                    $levelList[$key] = $temp;
                    // $levelList[$key] = $cateDetail;
                    unset($list[$key]);
                } // end if ParentId
            } // end foreach $list



            if( ! empty($levelList)){
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
                    if ( ! empty($subLevel)){
                        foreach ($subLevel as $key => $subLevelCateDetail) {
                            $levelAndSub[] = $subLevelCateDetail;
                        }
                    } // end if SubLevel
                } // end foreach LevelSorted
                return $levelAndSub;
            } // end if empty $level
        } // end if ! empty()
    } // end recursive()

    protected function getSortedCategory(){
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
//            ->addAttributeToFilter('level',array('eq'=>'0'))
//            ->setOrder('position','ASC')
        ;
//        Zend_Debug::dump($listCateLevel0->getData());
        $sortedArray = array();
        foreach($categories as $category){
            $sortedArray[] = array(
                'label' => $this->_separateCategoryLevelSign($category->getLevel(), '--')
                         . $category->getName(),
                'value' => $category->getId(),
            );
            $this->listSortedChildreenByCategoryId($category->getId());
//            if($cate->hasChildren()){
////                Zend_Debug::dump($cate->getAllChildren());
//                $childrenArray = explode(',',$cate->getChildren());
////                Zend_Debug::dump($childrenArray);
//
//                foreach ($childrenArray as $cateChild){
//                    $sortedArray[] = array(
//                        'label' => $this->_separateCategoryLevelSign($cateChild->getLevel(), '--')
//                                .  $cateChild->getName(),
//                        'value' => $cateChild->getId(),
//                    );
//                } // end foreach
////                Zend_debug::dump($childrenArray);
//            }
        }// end forearch
        Zend_Debug::dump($sortedArray);
    } // end method getSortedCategory

    public function listSortedChildrenByCategoryId($categoryId = ''){
        if (! $categoryId  || ! ctype_digit($categoryId)) {
            return FALSE;
        }
        $cateAndChilden = array();
        $cate = Mage::getModel('catalog/category')
            ->load($categoryId)
        ;
        $cateAndChilden[] = array(
            'label' => $this->_separateCategoryLevelSign($cate->getLevel(), '--')
                    . $cate->getName(),
            'value' => $cate->getId(),
        );
        if($cate->hasChildren()){
            $childrenArray = explode(',',$cate->getChildren());
            foreach ($childrenArray as $cateChild){
                $cateAndChilden[] = array(
                    'label' => $this->_separateCategoryLevelSign($cateChild->getLevel(), '--')
                        .  $cateChild->getName(),
                    'value' => $cateChild->getId(),
                );
                $this->listSortedChildrenByCategoryId($cateChild->getId());
            } // end foreach
//                Zend_debug::dump($childrenArray);
        } // end if
        return $cateAndChilden;
    } // end method listSortedChildernByCategoryId

    protected function _separateCategoryLevelSign($level='',$sign = '' ){
        $result = '';
        if ($level && ctype_digit($level) && ($level > 0) && $sign ) {
            for ($i = 0; $i < $level; $i++) {
                $result .= $sign;
            }
        }
        return $result;
    } // end method separateLevelSign
} // end class
// end file