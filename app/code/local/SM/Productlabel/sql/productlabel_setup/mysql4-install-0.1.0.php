<?php

//$installer = $this;
$installer = Mage::getResourceModel('catalog/setup','catalog_setup');
$installer->startSetup();
$installer->addAttribute('catalog_product', 'product_label', array(
	'group'  => 'Product Label',
	'type'   => 'varchar(255)',
	'input'  => 'multiselect',
	'label'  => 'Product Label',
	'source' => 'featured/featuredtype'
));
$installer->endSetup();