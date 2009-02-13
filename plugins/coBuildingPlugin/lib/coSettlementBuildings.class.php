<?php

/**
 * Provides information about buildings in settlement
 *
 * @author sognat
 */
class coSettlementBuildings {
  public static function levelFilter(sfEvent $event, $base)
  {
    $result = Doctrine_Query::create()
      ->from('FieldBuilding fb')
      ->leftJoin('fb.Building b')
      ->leftJoin('fb.Field f')
      ->leftJoin('f.Settlement s')
      ->where('s.id = ?', sfContext::getInstance()->getUser()->getSettlement()->id)
      ->andWhere('b.module_name = ?', strtolower($event['name']))
      ->fetchArray();

    foreach ($result as $building)
    {
      $levels[] = $building['level'];
    }

    return $levels;
  }
}
?>
