<?php

class LoginForm extends UserForm
{
  public function configure()
	{
		parent::configure();
		
		unset($this['id'], $this['re_password'], $this['mail'], $this['realname'], $this['sex'], $this['age'], $this['location'], $this['is_checked']);
		
		$this->validatorSchema->setPostValidator(new coValidatorUserLogin(
			'login', ':', 'password'
		));
	}
}