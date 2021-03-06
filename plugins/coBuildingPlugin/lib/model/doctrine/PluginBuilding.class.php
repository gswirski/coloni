<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PluginBuilding extends BaseBuilding
{
  public static function getBuildingsMetaAtView($view)
  {
    if (is_string($view))
    {
      $view = array($view);
    }
    
    if (!is_array($view))
    {
      throw new Exception('Invalid $view parameter format');
    }
    
    return Doctrine_Query::create()
      ->from('Building b')
      ->where('b.type = ?', $view[0])
      ->execute();
  }
}