<?php

include __DIR__.'/../bootstrap/doctrine.php';

$t = new lime_test(14, new lime_output_color());

$linkTable = Doctrine::getTable('Link');
/* @var $linkTable LinkTable */

$t->comment('update readonly hash');
$googleLink = $linkTable->findOneByUrl('http://www.google.ru');
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

$t->comment('create symlinks');
$firstYandexSymlink = $linkTable->createSymlink('http://yandex.ru');
$t->ok($firstYandexSymlink, 'yandex symlink is created');
$firstYandexSymlink->refresh();
$t->ok(strlen($firstYandexSymlink->id), 'symlink key is exists');
$t->comment('create second symlink');
$secondYandexLink = $linkTable->createSymlink('http://yandex.ru');
/* @var $secondYandexLink Symlink */
$yandexSymlinks = $secondYandexLink->Link->Symlinks;
$t->is(count($yandexSymlinks), 2, 'two symlinks are exist');
$t->is($yandexSymlinks[0]->id, $firstYandexSymlink->id, 'first keys are equal');

$t->comment('check validation');
$_SERVER['HTTP_HOST'] = 'jim-link';
try {
  $linkTable->createSymlink('http://jim-link/ololo');
  $t->fail('That is already short link');
}
catch (Doctrine_Validator_Exception $e) {
  $t->pass($e->getMessage());
}
try {
  $linkTable->createSymlink('www.atata.com');
  $t->fail('Url is invalid');
}
catch (Doctrine_Validator_Exception $e) {
  $t->pass($e->getMessage());
}
try {
  $linkTable->createSymlink('');
  $t->fail('Url is empty');
}
catch (Doctrine_Validator_Exception $e) {
  $t->pass($e->getMessage());
}

$t->comment('get fresh list');
$symlinks = Doctrine::getTable('Symlink')->getFresh(5);
$t->is(count($symlinks), 2, 'four symlinks');
$t->is(array_keys($symlinks[0]), array('id', 'link_id', 'created_at', 'url'), 'format is valid');
$t->is($symlinks[0]['link_id'], $symlinks[1]['link_id'], 'two symlinks of same url');