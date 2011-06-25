<?php

/**
 * entry actions.
 *
 * @package    jim-link
 * @subpackage entry
 * @author     Anthony Regeda
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class entryActions extends sfActionsExt
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if ($request->isMethod(sfRequest::POST) && isset($request['url'])) {
      try {
        $symlink = Doctrine::getTable('Link')->createSymlink($request['url']);
        $this->shrt = $this->getController()->genUrl('@redirect?short='.$symlink->id, true);
      }
      catch (Doctrine_Validator_Exception $e) {
        $this->error = 'Bad URL format';
      }
      if ($request->isXmlHttpRequest()) {
        return $this->outputJSON();
      }
      $this->url = $request['url'];
    }
    $this->symlinks = Doctrine::getTable('Symlink')->getFresh(sfConfig::get('app_symlink_list_size', 20));
  }

  /**
   * Redirect short url to original
   * @param sfWebRequest $request
   * @return string
   */
  public function executeRedirect(sfWebRequest $request)
  {
    if (isset($request['short'])) {
      $symlink = Doctrine::getTable('Symlink')->find($request['short']);
      /* @var $symlink Symlink */
      if ($symlink) {
        $this->url = $symlink->Link->url;
        if ($request->isXmlHttpRequest()) {
          return $this->outputJSON();
        }
        else {
          $this->redirect($this->url);
        }
      }
    }
    if ($request->isXmlHttpRequest()) {
      $this->error = 'Url is not found';
      return $this->outputJSON();
    }
    else {
      $this->redirect404();
    }
  }
}