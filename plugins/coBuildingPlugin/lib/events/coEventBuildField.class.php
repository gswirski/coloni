<?php

class coEventBuildField extends coEventBuild
{
  public static function register($building_id, $field_id, $settlement_id)
  {
    $instance = new self;
    $instance->_data = array('building' => $building_id, 'field' => $field_id, 'settlement' => $settlement_id);

    coEvent::register($instance);
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
  
  public function execute($event)
  {
    $data = Doctrine_Query::create()
      ->from('EventBuildField e')
      ->leftJoin('e.Field f')
      ->leftJoin('e.Building b')
      ->fetchArray();


    sfContext::getInstance()->getEventDispatcher()->notify(
      new sfEvent($this, 'settlement.build', $this->_data)
    );
    
    $buildingStatus = Doctrine_Query::create()
      ->from('FieldBuilding fb')
      ->where('fb.field_id = ?', $event->EventBuildField->field_id)
      ->andWhere('fb.building_id = ?', $event->EventBuildField->field_id)
      ->fetchOne();
      
    if($buildingStatus)
    {
      $buildingStatus->level += 1;
    }
    else
    {
      $buildingStatus = new FieldBuilding();
      $buildingStatus->field_id = $event->EventBuildField->field_id;
      $buildingStatus->building_id = $event->EventBuildField->building_id;
      $buildingStatus->level = 1;
    }
    
    $buildingStatus->save();
  }
}