<?php

final class coEventFactory
{
  public static function register(coEvent $event)
  {
    $object = new Event();
    $object->start = $event->getStart();
    $object->end   = $event->getEnd();
    $object->type  = $event->getType();
    
    if ($event instanceof coEventPermament)
    {
      $object->is_permament = 1;
      $object->EventPermament = $vent->getPermamentObject();
    }
    
    $event->addDataTo($object);
    
    $object->save();
  }
}