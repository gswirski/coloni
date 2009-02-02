<?php

/**
 * PluginUser form.
 *
 * @package    form
 * @subpackage User
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginUserForm extends BaseUserForm
{
  public function setup()
  {
    parent::setup();
    unset($this['is_checked']);
    
		$this->setWidget('password', new sfWidgetFormInputPassword());
		$this->setWidget('re_password', new sfWidgetFormInputPassword());
		
		$this->setValidator('login', new sfValidatorString(array('min_length' => 5, 'max_length' => 25)));
		$this->setValidator('password', new sfValidatorString(array('min_length' => 5, 'max_length' => 25)));
		$this->setValidator('re_password', new sfValidatorString(array('min_length' => 5, 'max_length' => 25)));
		$this->setValidator('mail', new sfValidatorAnd(array(
			new sfValidatorString(array('min_length' => 8, 'max_length' => 150)),
			new sfValidatorEmail()
		)));
		
		$this->validatorSchema->setPostValidator(
		  new sfValidatorAnd(array(
		    new sfValidatorSchemaCompare(
    			'password', '==', 're_password',
    			array(),
    			array('invalid' => 'Podane hasła muszą być identyczne')
    		),
    		new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('login'))),
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('mail'))),
		  ))
		);
		
	$this->widgetSchema->setPositions(array(
			'id', 'login', 'password', 're_password', 'mail', 'realname', 'sex', 'age', 'location'
		));
  }

	public function save($con = null) {
		$this->values['password'] = md5(sha1($this->values['password']));
		$user = parent::save($con);
		
		$user->UserToken[0]->token = md5(sha1($user->login . time() . '!)S@(A#*L$&T^)'));
		$user->save();
		
		sfContext::getInstance()->getEventDispatcher()->notifyUntil(new sfEvent(
    		  $this,
    		  'user.activate',
    		  array('user' => $user)
    		));
		
		return $user;
	}
}