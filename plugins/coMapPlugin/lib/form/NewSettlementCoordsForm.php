<?php

class NewSettlementCoordsForm extends sfForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'x' => new sfWidgetFormInput(array(), array('size' => 3)),
      'y' => new sfWidgetFormInput(array(), array('size' => 3))
    ));
    
    $this->widgetSchema->setNameFormat('coords[%s]');

    $this->setValidators(array(
      'x' => new sfValidatorNumber(),
      'y' => new sfValidatorNumber()
    ));
    
    $this->validatorSchema->setPostValidator(
      new coValidatorSettlementDistance('x', ',', 'y', array('position' => $this->getOption('position')))
    );
  }
}