<?php

class coEventBuildField extends coEventBuild
{
  public function __construct($building_id, $field_id, $settlement_id)
  {
    $this->_data = array('building' => $building_id, 'field' => $field_id, 'settlement' => $settlement_id);
  }
  
  public function getEnd()
  {
    return $this->getStart() + 60;
  }
  
  public function getType()
  {
    return 'BuildField';
  }
  
  public function addDataTo($event)
  {
    $event->type = 'BuildField';
    
    $event->EventSettlement[0]->role = 'builder';
    $event->EventSettlement[0]->settlement_id = $this->_data['settlement'];
    
    $event->EventBuildField->building_id = $this->_data['building'];
    $event->EventBuildField->field_id = $this->_data['field'];
  }
  
}