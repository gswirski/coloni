<?php

/**
 * map actions.
 *
 * @package    coloni
 * @subpackage map
 * @author     sognat
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mapActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeCountry(sfWebRequest $request)
  {
    $this->list = $this->getUser()->getObject()->Country[0]->listSettlements();
  }
  
  public function executeWorld(sfWebRequest $request)
  { 
    $position = Position::getObject($request->getParameter('x'), $request->getParameter('y'));
    
    $this->x = $position->x;
    $this->y = $position->y;
    
    $this->map_data = $position->listSettlementsOnArea(3, 3);
  }
}
