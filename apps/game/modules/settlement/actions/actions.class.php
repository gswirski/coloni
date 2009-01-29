<?php

/**
 * settlement actions.
 *
 * @package    coloni
 * @subpackage settlement
 * @author     sognat
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class settlementActions extends sfActions
{
  public function executeFields(sfWebRequest $request)
  {
    $this->settlement = Doctrine::getTable('Settlement')->find($request->getParameter('id'));
  }
}
