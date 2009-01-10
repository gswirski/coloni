<?php

class coValidatorUserLogin extends sfValidatorSchema
{
  const HAS_PASSWORD = ':';
  
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
    $this->addMessage('invalid', 'Invalid username or password');
    
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
    
    if ($this->getOption('operator') != self::HAS_PASSWORD) {
      throw new InvalidArgumentException(sprintf('The operator "%s" does not exist.', $this->getOption('operator')));
    }
    
    $user = sfContext::getInstance()->getUser();
    $user->setAttribute('login', $leftValue);
    $user->setAttribute('password', $rightValue);
    
    if(!$user->isGranted())
    {
      $error = new sfValidatorError($this, 'invalid', array(
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