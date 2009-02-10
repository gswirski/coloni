<?php

abstract class coEvent
{
  abstract function getType();
  abstract function addDataTo($event);
  
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