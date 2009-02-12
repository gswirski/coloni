<?php

abstract class coEventModule
{
  abstract function getType();
  abstract function addDataTo($event);

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