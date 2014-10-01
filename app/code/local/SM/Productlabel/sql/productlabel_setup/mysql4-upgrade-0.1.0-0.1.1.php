<?php

//$installer = $this;
$installer = Mage::getResourceModel('catalog/setup','catalog_setup');
$installer->startSetup();
$installer->removeAttribute('catalog_product', 'product_label');
$installer->addAttribute('catalog_product', 'product_label', array(
	'group'  => 'Product Label',
	'type'   => 'varchar',
    'backend'=> 'eav/entity_attribute_backend_array',
	'input'  => 'multiselect',
	'label'  => 'Product Label',
	'source' => 'productlabel/source_productlabeltype',
));
$installer->endSetup();