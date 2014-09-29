<?php

//$installer = $this;

$installer = Mage::getResourceModel('catalog/setup','catalog_setup');
//echo "<pre>";
//die(var_dump($installer));

$installer->startSetup();

$installer->removeAttribute('catalog_product', 'is_bestseller');
//die('run success');
$installer->endSetup();