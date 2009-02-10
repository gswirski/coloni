<?php

class coEventBuildField extends coEventBuild
{
  public static function create($building_id, $field_id, $settlement_id)
  {
    $instance = new self;
    $instance->_data = array('building' => $building_id, 'field' => $field_id, 'settlement' => $settlement_id);
    return $instance;
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
  
  public function execute($object)
  {
    $buildingStatus = Doctrine_Query::create()
      ->from('FieldBuilding fb')
      ->where('fb.field_id = ?', $object->EventBuildField->field_id)
      ->andWhere('fb.building_id = ?', $object->EventBuildField->field_id)
      ->fetchOne();
      
    if($buildingStatus)
    {
      $buildingStatus->level += 1;
    }
    else
    {
      $buildingStatus = new FieldBuilding();
      $buildingStatus->field_id = $object->EventBuildField->field_id;
      $buildingStatus->building_id = $object->EventBuildField->building_id;
      $buildingStatus->level = 1;
    }
    
    $buildingStatus->save();
  }
}