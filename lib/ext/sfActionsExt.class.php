<?php

/**
 * Description of sfActionsExt
 *
 * @author regeda
 */
class sfActionsExt extends sfActions
{
  /**
   * Output JSON
   * @return string
   */
  public function outputJSON()
  {
    $result = json_encode($this->getVarHolder()->getAll());
    if (isset($this->request['callback']))
    {
      $result = $this->request['callback'].'('.$result.')';
      $contentType = 'application/x-javascript';
    }
    else
    {
      $contentType = 'application/json';
    }
    $this->response->setHttpHeader('Content-Length', strlen($result));
    $this->response->setContentType($contentType);
    $this->response->setContent($result);
    return sfView::NONE;
  }
}