<?php

/**
 * Provides user view for Event Engine
 *
 * @author sognat
 */
class eventComponents extends sfComponents
{
  public function executeList()
  {
    $this->list = coEvent::getInstance()->getList();
  }
}