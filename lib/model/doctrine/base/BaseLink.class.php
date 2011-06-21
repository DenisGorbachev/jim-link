<?php

/**
 * BaseLink
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $hash
 * @property string $url
 * @property Doctrine_Collection $Symlinks
 * 
 * @method string              getHash()     Returns the current record's "hash" value
 * @method string              getUrl()      Returns the current record's "url" value
 * @method Doctrine_Collection getSymlinks() Returns the current record's "Symlinks" collection
 * @method Link                setHash()     Sets the current record's "hash" value
 * @method Link                setUrl()      Sets the current record's "url" value
 * @method Link                setSymlinks() Sets the current record's "Symlinks" collection
 * 
 * @package    jim-link
 * @subpackage model
 * @author     Anthony Regeda
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLink extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('link');
        $this->hasColumn('hash', 'string', 32, array(
             'type' => 'string',
             'fixed' => 1,
             'notnull' => true,
             'unique' => true,
             'length' => 32,
             ));
        $this->hasColumn('url', 'string', 1024, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 1024,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Symlink as Symlinks', array(
             'local' => 'id',
             'foreign' => 'link_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             'updated' => 
             array(
              'disabled' => true,
             ),
             ));
        $this->actAs($timestampable0);
    }
}