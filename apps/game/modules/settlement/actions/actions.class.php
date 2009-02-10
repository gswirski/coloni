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
  public function executeProductionArea(sfWebRequest $request)
  {
    $this->getUser()->setSettlement($request->getParameter('id'));
    $this->settlement = $this->getUser()->getSettlement();
  }
  
  public function executeDefencesArea(sfWebRequest $request)
  {
    $this->getUser()->setSettlement($request->getParameter('id'));
    $this->settlement = $this->getUser()->getSettlement();  }
  
  public function executeCityArea(sfWebRequest $request)
  {
    $this->getUser()->setSettlement($request->getParameter('id'));
    $this->settlement = $this->getUser()->getSettlement();  }
  
  public function executeSquareArea(sfWebRequest $request)
  {
    $this->getUser()->setSettlement($request->getParameter('id'));
    $this->settlement = $this->getUser()->getSettlement();  }
  
  public function executeFound(sfWebRequest $request)
  {
    $this->getUser()->setSettlement($request->getParameter('id'));
    $this->settlement = $this->getUser()->getSettlement();
    
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

  public function executeProductionField(sfWebRequest $request)
  {
    sfContext::getInstance()->getEventDispatcher()->notify(new sfEvent(
      $this,
      'settlement.build'
    ));
    
    if ($request->isMethod('post'))
    {
      $this->getUser()->setSettlement($request->getParameter('settlement_id'));
      
      $settlement = $this->getUser()->getSettlement()->id;
      $field = $request->getParameter('field_id');
      $building = $request->getParameter('building_id');
      
      $event = coEventBuildField::create($building, $field, $settlement);
      coEventFactory::register($event);
      
      $this->redirect("@settlement?id={$settlement}");
    } 
    else 
    {
      $this->buildings = Building::getBuildingsMetaAtView('production');
    }
  }
}
