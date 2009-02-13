<?php

/**
 * Basic class for most event operations
 *
 * @author sognat <sognat@gmail.com>
 */
class coEvent {

  /*
   * Instance of coEvent class
   * @var coEvent
   */
  protected static $instance;

  protected $list_by_type;

  protected $list_by_time;

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

  public function addToList($event)
  {
    $this->list_by_type[$event['type']][] = $event;

    $this->list_by_time[] = $event;
  }

  public function getList($type = '')
  {
    if (!$type)
    {
      return $this->list_by_time;
    }
    else
    {
      return $this->list_by_type[$type];
    }
  }

  /*
   * Private constructor to prevent from multiple instances
   */
  protected function __construct() {}

  /*
   * Registrates new event
   *
   * @param coEventModule $event
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
