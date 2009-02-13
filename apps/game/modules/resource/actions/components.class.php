<?php

/**
 * Provides user view for resources production
 *
 * @author sognat
 */
class resourceComponents extends sfComponents
{
  public function executeProduction()
  {
    $this->productionList = array(array(
      'resource' => 'wood',
      'amount' => coResource::getProduction('wood')
    ));
  }
}