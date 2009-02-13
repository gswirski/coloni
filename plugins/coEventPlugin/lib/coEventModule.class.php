<?php

abstract class coEventModule
{
  protected $data = array();

  abstract function getType();
  abstract function addDataTo($event);

  public function getEventData($event)
  {
    return $event->toArray();
  }

  public static function register()
  {
    coEvent::register(new self());
  }

  public function getStart()
  {
    return time();
  }
  
  public function getEnd()
  {
    return time();
  }
  
  public function isPermament()
  {
    return 0;
  }
}