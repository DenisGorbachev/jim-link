<?php

include __DIR__.'/unit.php';

new sfDatabaseManager($configuration);
Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');