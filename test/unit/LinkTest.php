<?php

include __DIR__.'/../bootstrap/doctrine.php';

$t = new lime_test(4, new lime_output_color());

$googleLink = Doctrine::getTable('Link')->findOneByUrl('http://www.google.ru');
/* @var $googleLink Link */
$t->ok($googleLink, 'google link is found');
$t->is($googleLink->hash, '732835f518e918bfe36321057d1b81a2', 'the hash is verified');

$googleLink->hash = 'ololo';
$googleLink->save();
$googleLink->refresh();
$t->is($googleLink->hash, '732835f518e918bfe36321057d1b81a2', 'the hash was not modified');

$googleLink->url = 'http://google.ru';
$googleLink->save();
$googleLink->refresh();
$t->is($googleLink->hash, '545f72bf584a6ce29a8f1ae7ef422319', 'the hash was modified');