<?php

class coBaseUser extends sfBasicSecurityUser
{ 
  protected $isAuthChecked = 0;
  
  public function setAuthenticated($is)
  {
    if (false === $is)
    {
      $this->attributeHolder->remove('login');
      $this->attributeHolder->remove('password');
      $this->isAuthChecked = 0;
    }
  }
  
  public function isAuthenticated()
  {
    if (!$this->isAuthChecked)
    {
      $user = $this->getObject();
      if ($user)
      {
        $this->isAuthChecked = 1;
        return true;
      }
      return false;
    }
    
    return true;
  }
  
  public function getObject()
  {
    $q = Doctrine_Query::create()
      ->from('User u')
      ->where('u.login = ?', $this->getAttribute('login'))
      ->andWhere('u.password = ?', $this->getAttribute('password'));
      
    return $q->fetchOne();
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
