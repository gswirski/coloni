<?php

class coBaseUser extends sfBasicSecurityUser
{ 
  protected $isAuthChecked = 0;
  protected $userObject = null;
  protected $settlementObject = null;
  
  public function setAuthenticated($is)
  {
    if (false === $is)
    {
      $this->attributeHolder->remove('login');
      $this->attributeHolder->remove('password');
      $this->isAuthChecked = 0;
      $this->userObject = null;
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
    if (!$this->userObject)
    {
      $q = Doctrine_Query::create()
        ->from('User u')
        ->where('u.login = ?', $this->getAttribute('login'))
        ->andWhere('u.password = ?', $this->getAttribute('password'));

      $this->userObject = $q->fetchOne();
    }
    
    return $this->userObject;
  }
  
	public function setAttribute($name, $value, $ns = null)
	{
		if ($name == 'password')
		{
			$value = md5(sha1($value));
		}
		
		parent::setAttribute($name, $value, $ns = null);
	}
	
	public function setSettlement($settlement_id)
	{
	  $this->setAttribute('settlement', $settlement_id);
	}
	
	public function getSettlement()
	{
    if (!$this->getAttribute('settlement'))
    {
      $this->settlementObject = $this->getObject()->Country[0]->Settlement[0];
      $this->setAttribute('settlement', $this->settlementObject->id);
    }

	  if (!$this->settlementObject)
	  {
      $this->settlementObject = Doctrine::getTable('Settlement')->find(
        $this->getAttribute('settlement')
      );

	  }
	  return $this->settlementObject;
	}
}
