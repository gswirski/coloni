<?php

class coBaseUser extends sfBasicSecurityUser
{ 
  
  /*
   * Sends message
   */
  public function sendMessage($data) // Please specify your own API
  {
    
  }
  
  /*
   * Returns array of messages
   *
   * @param $user
   * @param $columns Array with columns to retrive from database
   * @param $view Folder with messages (inbox, outbox, etc...)
   */
  public function listMessages(User $user, $columns, $view = 'inbox')
  {
    
  }
  
  /*
   * Retrives and returns Message object from database with specified id
   */
  public function getMessage($id)
  {
    
  }
  
  /*
   * Generates new user token and saves it in database
   *
   * @param $user   {@link User} Doctrine User object
   */
  public function generateToken(User $user)
  {
    $token = MD5(SHA1($user['login'] . time() . '!)S@(A#*L$&T^)'));
  }
  
  /*
   * Checks if token is correct and updates user state
   * 
   * @param $user   {@link User} Doctrine User object
   * @param $token  string with user token
   */
  public function checkTokenAndUpdate(User $user, $token)
  {
    if ($this->checkToken($user, $token))
    {
      
    }
  }
  
  /* Checks if token is true
   *
   * @param $user   {@link User} Doctrine User object
   * @param $token  string with user token
   * @return BOOL    true if correct, false if not
   */
  protected function checkToken(User $user, $token)
  {
    
  }
  
  public function getObject()
  {
    $q = Doctrine_Query::create()
      ->from('User u')
      ->where('u.login = ?', $this->getAttribute('login'))
      ->andWhere('u.password = ?', $this->getAttribute('password'));
      
    return $q->fetchOne();
  }
  
	public function isGranted()
	{
	  $user = $this->getObject();
		
		if ($user)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function setAttribute($name, $value, $ns = null)
	{
		if ($name == 'password')
		{
			$value = md5(sha1($value));
		}
		
		parent::setAttribute($name, $value, $ns = null);
	}
}
