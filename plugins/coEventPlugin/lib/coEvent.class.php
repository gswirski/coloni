<?php

/**
 * Basic class for most event operations
 *
 * @author sognat <sognat@gmail.com>
 */
class coEvent {

  /*
   * @var $instance coEvent instance
   */
  protected static $instance;

  /*
   * Returns always the same coEvent object
   *
   * @return coEvent
   */
  public static function getInstance()
  {
    if (!self::$instance)
    {
      self::$instance = new self;
    }

    return self::$instance;
  }


  /*
   * Private constructor to prevent from multiple instances
   */
  protected function __construct() {}

  /*
   * Registrates new event
   */
  public static function register(coEventModule $event)
  {
    $object = new Event();
    $object->start = $event->getStart();
    $object->end   = $event->getEnd();
    $object->type  = $event->getType();

    if ($event instanceof coEventPermament)
    {
      $object->is_permament = 1;
      $object->EventPermament = $vent->getPermamentObject();
    }

    $event->addDataTo($object);

    $object->save();
  }
}
?>
