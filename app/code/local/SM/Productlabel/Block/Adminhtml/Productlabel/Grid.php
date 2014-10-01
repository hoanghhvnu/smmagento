<?php

class SM_Productlabel_Block_Adminhtml_Productlabel_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {

//      echo __METHOD__;
      parent::__construct();
      $this->setId('productlabelGrid');
      $this->setDefaultSort('label_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('productlabel/productlabel')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('label_id', array(
          'header'    => Mage::helper('productlabel')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'label_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('productlabel')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));

      $this->addColumn('position', array(
          'header'    => Mage::helper('productlabel')->__('Position'),
          'align'     =>'left',
          'index'     => 'position',
          'type'      => 'options',
          'options'   => Mage::helper('productlabel/retrievelabel')->getPositionAsKeyValue(),
      ));

      $this->addColumn('imagepreview', array(
          'header'    => Mage::helper('productlabel')->__('Image Preview'),
          'align'     =>'left',
          'index'     => 'image_name',
          'sortable'      => false,
          'filter'      => false,
          'renderer' => 'productlabel/adminhtml_productlabel_renderer_imagepreview',
      ));
      $this->addColumn('status', array(
          'header'    => Mage::helper('productlabel')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));


	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('productlabel')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('productlabel')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('label_id');
        $this->getMassactionBlock()->setFormFieldName('productlabel');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('productlabel')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('productlabel')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('productlabel/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('productlabel')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('productlabel')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
//      return $this->getUrl('*/adminhtml_productlabel/index', array('filterproductlabelid' => $row->getId()));
  }

}