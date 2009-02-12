<?php

class coEventFilter extends sfFilter
{
  /*
   * @var $event_list Doctrine_Collection
   */
  protected $event_list;

  /*
   * Executes filter
   *
   * @param $filterChain $sfFilterChain
   */
  public function execute(sfFilterChain $filterChain)
  {
    $context = sfContext::getInstance();

    $context->getEventDispatcher()->notify(new sfEvent(
      $this,
      'event.start_processing'
    ));

    $settlement = $context->getUser()->getSettlement();
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

    $context->getEventDispatcher()->notify(new sfEvent(
      $this,
      'event.end_processing'
    ));
    
    $filterChain->execute();
  }

  /*
   * Gets settlement events
   *
   * @param $settlement Settlement
   */
  protected function getRelatedEvents($settlement)
  {
    return Doctrine_Query::create()
      ->from('Event e')
      ->leftJoin('e.EventSettlement es')
      ->where('es.settlement_id = ?', $settlement->id)
      ->orderBy('e.end')
      ->execute();
  }


}