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
        $handle = $this->getCategoryForForm();
        array_unshift($handle, array('value' => 'cms_index_index', 'label' => 'Home page'));
        array_unshift($handle, array('value' => 'catalog_category_view', 'label' => 'All category page'));
        return $handle;
    } // end method

    protected function collectData()
    {

    } // end method
    public function getCategoryForForm(){
        $raw = $this->getCategory();
        $list = array();
        foreach ($raw as $cate){
            $list[] = array(
                'value' => 'CATEGORY_' . $cate['cate_id'],
                'label' => $cate['cate_name'],
            );
        }
        return $list;
    }

    private function getCategory($levelSign = ""){
        $sequenceList = $this->getRawCategory();
        if( !empty($sequenceList)){
            // get Category level 0, ParentId = 0;
            $strLevel = "";
            $sortedList = $this->recursive(0, $sequenceList, $strLevel);
            return $sortedList;
        } // end if empty
    } // end getCategory


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
} // end class
// end file