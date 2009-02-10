<?php

class coEventFilter extends sfFilter
{
  public function execute(sfFilterChain $filterChain)
  {
    $settlement = sfContext::getInstance()->getUser()->getSettlement();
    $events = $this->getRelatedEvents($settlement);
    
    foreach ($events as $event)
    {
      $duration = $event->end - time();
      echo 'Duration: ' . $duration . "<br />";
    }
    
    $this->garbageCollect($events);
    
    $filterChain->execute();
  }
  
  protected function getRelatedEvents($settlement)
  {
    return Doctrine_Query::create()
      ->from('Event e')
      ->leftJoin('e.EventSettlement es')
      ->leftJoin('e.EventPermament ep')
      ->leftJoin('e.EventBuildField ebf')
      ->leftJoin('e.EventBuildCity ebc')
      ->leftJoin('e.EventTerraform et')
      ->where('es.settlement_id = ?', $settlement->id)
      ->orderBy('e.end')
      ->execute();
  }
  
  protected function garbageCollect($events)
  {
    foreach ($events as $event)
    {
      if ($event->end < time())
      {
        $event->delete();
      }
    }
  }
}