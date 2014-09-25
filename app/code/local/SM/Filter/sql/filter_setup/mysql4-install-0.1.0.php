<?php
//die('run filter script');
$installer = $this;
$installer->startSetup();
$tableName = $installer->getTable('catalog/eav_attribute');

$installer->getConnection()->addColumn(
    $tableName,
    "filter_frontend_renderer_type",
    "TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'"
);

$installer->endSetup();