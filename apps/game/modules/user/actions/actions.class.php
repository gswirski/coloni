<?php

/**
 * login actions.
 *
 * @package    coloni
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class userActions extends sfActions
{
	public function executeLogin(sfWebRequest $request)
	{
		$this->form = new LoginForm();

		if ($request->isMethod('post'))
		{
		  $this->form->bind($request->getParameter('user'));
		  if ($this->form->isValid())
		  {
				$this->getUser()->setAuthenticated(true);
				$this->redirect('@homepage');
		  }
		}
	}
	
  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->setAuthenticated(false);
    $this->redirect('@homepage');
  }

	public function executeRegister(sfWebRequest $request)
	{
		$this->form = new UserForm();

		if ($request->isMethod('post'))
		{
		  $this->form->bind($request->getParameter('user'));
		  if ($this->form->isValid())
		  {
				$this->form->save();
				$this->redirect('@login');
		  }
		}		
	}
}
