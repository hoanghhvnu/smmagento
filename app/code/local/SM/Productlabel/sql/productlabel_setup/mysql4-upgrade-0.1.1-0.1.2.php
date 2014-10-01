<?php

$installer = $this;
$installer->startSetup();

$installer->run("


 -- DROP TABLE IF EXISTS {$this->getTable('productlabel/productlabel')};

CREATE TABLE {$this->getTable('productlabel/productlabel')} (
  `label_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) not null,
   `image_name` varchar(255) not null,
   `position` varchar(255) not null,
   `status` varchar(255) not null,
  PRIMARY KEY (`label_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup(); 