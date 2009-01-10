<?php

class coSecurityUser extends sfBasicSecurityUser
{
	public function isGranted()
	{
	    $q = Doctrine_Query::create()
	        ->from('User u')
	        ->where('u.login = ?', $this->getAttribute('login'))
	        ->andWhere('u.password = ?', $this->getAttribute('password'));
	        
		$user = $q->fetchOne();
		
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
