<?php

/**
 * map actions.
 *
 * @package    coloni
 * @subpackage map
 * @author     Your name here
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
  }
  
  public function executeWorld(sfWebRequest $request)
  {
    $this->x = $request->getParameter('x');
    $this->y = $request->getParameter('y');
    
    if ($this->x == 'default' or $this->y == 'default')
    {
      $user = $this->getUser()->getObject();
      //Settlement::getMainCountryPosition($user);
    }
  }
}
