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
  public function executeResources(sfWebRequest $request)
  {
    $this->settlement = Doctrine::getTable('Settlement')->find($request->getParameter('id'));
  }
  
  public function executeFound(sfWebRequest $request)
  {
    $this->settlement = Doctrine::getTable('Settlement')->find($request->getParameter('id'));
    $this->form = new NewSettlementCoordsForm(array(), array('position' => $this->settlement->position));
    
    if ($request->isMethod('post'))
    {
		  $this->form->bind($request->getParameter('coords'));
      if ($this->form->isValid())
      {
        $country = $this->settlement->Country;
        Settlement::foundNew($country, $this->form->getValues(), '', 'village', $this->settlement);
        $country->save();
        
        $this->redirect("@country_map");
      }
    }
  }
}
