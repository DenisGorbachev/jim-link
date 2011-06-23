<?php

/**
 * SymlinkTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class SymlinkTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object SymlinkTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Symlink');
    }

    /**
     * Returns recent symlinks
     * @param int $limit
     * @return array
     */
    static public function getFresh($limit)
    {
      $q = Doctrine_Query::create()
        ->from('Symlink s')
        ->orderBy('s.created_at DESC')
        ->limit($limit);
      $result = $q->execute();
      $symlinks = $result->toArray();
      $linkIds = array();
      foreach ($symlinks as $symlink) {
        $linkIds[] = $symlink['link_id'];
      }
      $q = Doctrine_Query::create()
        ->select('l.url')
        ->from('Link l INDEXBY l.id')
        ->whereIn('l.id', array_unique($linkIds));
      $result = $q->execute();
      $links = $result->toArray();
      foreach ($symlinks as &$symlink) {
        $symlink['url'] = $links[$symlink['link_id']]['url'];
      }
      return $symlinks;
    }
}