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
      $executor = 'coEvent' . $event['type'];
      $executor = new $executor;

      if ($event->end < time())
      {
        $executor->execute($event);
        
        $event->delete();
      }
      else
      {
        coEvent::getInstance()->addToList($executor->getEventData($event));
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