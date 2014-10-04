<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/15/14
 * Time: 10:56 AM
 */
//die('hoange');
//die($this->getTable('slider/slider'));
$installer = $this;
$installer->startSetup();

$installer->run("
     ALTER TABLE {$this->getTable('slider/slider')}

     ADD COLUMN `before_after` varchar(255),
     ADD COLUMN `block_name` varchar(255)
    ");

// ADD COLUMN `handle` varchar(255) not null,


$installer->endSetup();