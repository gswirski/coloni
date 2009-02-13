<?php

class coEventBuildField extends coEventBuild
{
  public static function register()
  {
    $instance = new self;
    $instance->register_data = array('building' => func_get_arg(0), 'field' => func_get_arg(1), 'settlement' => func_get_arg(2));

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
    $event->EventSettlement[0]->settlement_id = $this->register_data['settlement'];
    
    $event->EventBuildField->building_id = $this->register_data['building'];
    $event->EventBuildField->field_id = $this->register_data['field'];
  }
  
  public function execute($event)
  {
    $data = $this->getEventData($event);

    sfContext::getInstance()->getEventDispatcher()->notify(
      new sfEvent($this, 'settlement.build', $data)
    );
    
    $buildingStatus = Doctrine_Query::create()
      ->from('FieldBuilding fb')
      ->where('fb.field_id = ?', $data['EventBuildField']['field_id'])
      ->andWhere('fb.building_id = ?', $data['EventBuildField']['building_id'])
      ->fetchOne();
      
    if($buildingStatus)
    {
      $buildingStatus->level += 1;
    }
    else
    {
      $buildingStatus = new FieldBuilding();
      $buildingStatus->field_id = $data['EventBuildField']['field_id'];
      $buildingStatus->building_id = $data['EventBuildField']['building_id'];
      $buildingStatus->level = 1;
      $buildingStatus->save();

      $field = $buildingStatus->Field;
      $field->type = 'building';
    }
    
    $buildingStatus->save();
  }

  public function getEventData($event)
  {
    $data = parent::getEventData($event);

    $data['EventBuildField'] = Doctrine_Query::create()
      ->from('EventBuildField e')
      ->leftJoin('e.Field f')
      ->leftJoin('e.Building b')
      ->execute();
    
    $data['EventBuildField'] = $data['EventBuildField'][0];

    return $data;
  }
}