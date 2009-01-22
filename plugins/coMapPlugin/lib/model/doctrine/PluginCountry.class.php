<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PluginCountry extends BaseCountry
{
  public static function onActivateCreateNew(sfEvent $event)
  {
    $user = $event['user'];
    $user->Country[0]->name = 'Jakieś państwo';
    
    $settlement = $user->Country[0]->Settlement[0];
    $settlement->type = 'capital';
    $settlement->name = 'Jakaś osada';
    
    $position = Position::useFirstFreePosition();
    
    $x = $position->x * 10;
    $y = $position->y * 10;
    
    $i = 0;
    
    $positions = array(
      array(-1, -3),
      array( 0, -3),
      array( 1, -3),
      
      array(-2, -2),
      array(-1, -2),
      array( 0, -2),
      array( 1, -2),
      array( 2, -2),
      
      array(-3, -1),
      array(-2, -1),
      array(-1, -1),
      array( 0, -1),
      array( 1, -1),
      array( 2, -1),
      array( 3, -1),
      
      array(-3, 0),
      array(-2, 0),
      array(-1, 0),
      array( 0, 0),
      array( 1, 0),
      array( 2, 0),
      array( 3, 0),
      
      array(-3, 1),
      array(-2, 1),
      array(-1, 1),
      array( 0, 1),
      array( 1, 1),
      array( 2, 1),
      array( 3, 1),
      
      array(-2, 2),
      array(-1, 2),
      array( 0, 2),
      array( 1, 2),
      array( 2, 2),
      
      array(-1, 3),
      array( 0, 3),
      array( 1, 3)
    );
    
    foreach ($positions as $position)
    {
      $settlement->Field[$i]->x = $x + $position[0];
      $settlement->Field[$i]->y = $y + $position[1];
      if ($position[0] == 0 and $position[1] == 0)
      {
        $settlement->Field[$i]->type = 'city';
      }
      else
      {
        $settlement->Field[$i]->type = 'village';
      }
      $i++;
    }
    
    $user->save();
    // $country = new Country();
    // // $country->...
    // // $country->save();
    // 
    // $position = Position::useFirstFreePosition();
    // print_r($position);
    // 
    // $field = new Field();
    // 
    // $settlement = new Settlement();
    // 
  }
  
}