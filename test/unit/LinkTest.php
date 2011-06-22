<?php

include __DIR__.'/../bootstrap/doctrine.php';

$t = new lime_test(9, new lime_output_color());

$linkTable = Doctrine::getTable('Link');

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
$yandexLink = $linkTable->createSymlink('http://yandex.ru');
$t->ok($yandexLink, 'yandex link is created');
$yandexSymlinks = $yandexLink->Symlinks;
$t->is(count($yandexSymlinks), 1, 'one symlink is created');
$firstYandexSymlink = $yandexSymlinks[0];
/* @var $firstYandexSymlink Symlink */
$firstYandexSymlink->refresh();
$t->ok(strlen($firstYandexSymlink->key), 'symlink key is exists');
$t->comment('create second symlink');
$yandexLink = $linkTable->createSymlink('http://yandex.ru');
$yandexSymlinks = $yandexLink->Symlinks;
$t->is(count($yandexSymlinks), 2, 'two symlinks are exist');
$t->is($yandexSymlinks[0]->key, $firstYandexSymlink->key, 'first keys are equal');