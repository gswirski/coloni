<?php

class coValidatorSettlementDistance extends sfValidatorSchema
{
  const COORDS_SEPARATOR = ',';
  
  protected $options = array('position' => '');
  
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * left_field:         The left field name
   *  * operator:           The comparison operator
   *                          * self::HAS_PASSWORD
   *  * right_field:        The right field name
   *  * throw_global_error: Whether to throw a global error (false by default) or an error tied to the left field
   *
   * @param string $leftField   The left field name
   * @param string $operator    The operator to apply
   * @param string $rightField  The right field name
   * @param array  $options     An array of options
   * @param array  $messages    An array of error messages
   *
   * @see sfValidatorBase
   */
  public function __construct($leftField, $operator, $rightField, $options = array(), $messages = array())
  {
    $this->addMessage('too_short', 'The distance must be longer than 3 fields');
    $this->addMessage('too_long', 'The distance must be shorter than 7 fields');
    
    
    $this->addOption('left_field', $leftField);
    $this->addOption('operator', $operator);
    $this->addOption('right_field', $rightField);
    
    $this->addOption('throw_global_error', false);
    
    parent::__construct(null, $options, $messages);
  }
  
  /**
   * @see sfValidatorBase
   */
  protected function doClean($values)
  {
    if (is_null($values))
    {
      $values = array();
    }
    
    if (!is_array($values))
    {
      throw new InvalidArgumentException('You must pass an array parameter to the clean() method');
    }
    
    $leftValue  = isset($values[$this->getOption('left_field')]) ? $values[$this->getOption('left_field')] : null;
    $rightValue = isset($values[$this->getOption('right_field')]) ? $values[$this->getOption('right_field')] : null;
    
    if ($this->getOption('operator') != self::COORDS_SEPARATOR) {
      throw new InvalidArgumentException(sprintf('The operator "%s" does not exist.', $this->getOption('operator')));
    }
    
    $base_x = $this->getOption('position')->x;
    $base_y = $this->getOption('position')->y;
    $new_x = $leftValue;
    $new_y = $rightValue;
    
    $width = abs($new_x - $base_x);
    $height = abs($new_y - $base_y);
    
    $distance = sqrt(pow($width,2) + pow($height,2));
    $error = '';
    
    if ($distance < 3)
    {
      $error = 'too_short';
    }
    
    if ($distance > 7)
    {
      $error = 'too_long';
    }
    
    if ($error)
    {
      $error = new sfValidatorError($this, $error, array(
        'left_field'  => $leftValue,
        'right_field' => $rightValue,
        'operator'    => $this->getOption('operator'),
      ));
      if ($this->getOption('throw_global_error'))
      {
        throw $error;
      }
      
      throw new sfValidatorErrorSchema($this, array($this->getOption('left_field') => $error));
    }
    
    return $values;
  }
  
  /**
   * @see sfValidatorBase
   */
  public function asString($indent = 0)
  {
    $options = $this->getOptionsWithoutDefaults();
    $messages = $this->getMessagesWithoutDefaults();
    unset($options['left_field'], $options['operator'], $options['right_field']);
    
    $arguments = '';
    if ($options || $messages)
    {
      $arguments = sprintf('(%s%s)',
        $options ? sfYamlInline::dump($options) : ($messages ? '{}' : ''),
        $messages ? ', '.sfYamlInline::dump($messages) : ''
      );
    }
    
    return sprintf('%s%s %s%s %s',
      str_repeat(' ', $indent),
      $this->getOption('left_field'),
      $this->getOption('operator'),
      $arguments,
      $this->getOption('right_field')
    );
  }
}