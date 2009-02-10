<?php

class coEventFilter extends sfFilter
{
  public function execute(sfFilterChain $filterChain)
  {
    $settlement = sfContext::getInstance()->getUser()->getSettlement();
    $events = $this->getRelatedEvents($settlement);
    
    foreach ($events as $event)
    {
      if ($event->end < time())
      {
        $executor = 'coEvent' . $event['type'];
        $executor = new $executor;
        $executor->execute($event);
        echo 'Has been built. <br />';
        
        $event->delete();
      }
      else
      {
        echo $event->end - time() . ' seconds left. <br />';
      }
    }
    
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
}