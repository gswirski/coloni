<?php
/**
 * Main coResourcePlugin code
 * @package coResourcePlugin
 * @author Vanilla
 */

/**
 * Resource exception
 * @package coResourcePlugin
 */
class ResourceException extends Exception {} 
/**
 * Static class for important resource operations
 *  !!! NOT THREAD SAFE !!! 
 * @package coResourcePlugin
 */
class coResource
{
	/**
	 * Precached stuff
	 * @var array
	 */
	private static $precache = array();
	/**
	 * Buffy the Circular Reference Slayer
	 * @var array
	 */
	private static $buffy = array();
	/**
	 * Does just as name says
	 * @param int $rsid resource.id
	 * @param int $rsname resource.resource_name
	 * @return array array of dependency entries
	 */
	static private function GetResourceDependencies($rsid,$rsname)
	{
		$data = Doctrine_Query::create()->from('ResourceDependency rd')
			 	->where('rd.dependency_for = ?',$rsid)
			 	->execute(array(), Doctrine::HYDRATE_ARRAY);
		if (!$data)
			throw new ResourceException('Inconsistency for dependency records of "'.$rsname.'" - none found');
		return $data;				
	}
	
	/**
	 * Does just as name says
	 */
	static private function PrecacheEverything()
	{
		foreach(Doctrine_Query::create()
							->from('Resource r')
							->execute(array(), Doctrine::HYDRATE_ARRAY) as $item)
		{
			$rsname = $item['resource_name'];
			self::$precache[$rsname] = $item;
			self::$precache[$rsname]['dependencies'] = self::GetResourceDependencies($item['id'],$rsname);
		}
		
	}
	/**
	 * Gets single resources data
	 * Generally here to implement caching on demand
	 * @param string $resource resource name
	 * @return array resource entry
	 */
	static private function GetResourceInfo($resource)
	{
		if (in_array($resource, self::$buffy))
			throw new ResourceException('Circular reference - tried to access '.$resource);
			// if was precached, then return precached values
		if (self::$precache == array()) self::PrecacheEverything();
		return self::$precache[$resource];
	}
	  /**
 	  * Gets item(building/tech. ) level
	  * @param string $item item name
	  * @param string $type item type(building | technology | resource)
	  * @return int Item's level
	  */
  	static private function getItemLevel($name,$type)
  	{
	    $eventName = 'settlement.' . ($type=='resource' ? 'resource_count' : $type.'_level');
	    $levels = sfContext::getInstance()->getEventDispatcher()->filter(
        	new sfEvent(new self, $eventName, array('name' => $name)), array(0));
    	return $levels->getReturnValue();
  }
	/**
	 * Part of the interface
	 * Get resources by resource types
	 * @param $types array if empty array returns all possible resources, else filters them by resource types as elements of $types array
	 * @return array array of resource names
	 */
	static public function getResources($types = array())
	{
		if (self::$precache == array()) self::PrecacheEverything();
		$retval = array();
		if ($types == array())
		{
			return array_keys(self::$precache);
		} else
		foreach (self::$precache as $item)
		{
			if (in_array($item['resource_type'],$types)) $retval[] = $item['resource_name'];
		}
		return $retval;
		
	}
	
	/**
	 * Part of the interface
	 */
	static public function getProduction($resource='')
	{
		$dat = self::relaygetProduction($resource);
		self::$buffy = array();
		return $dat;
	} 
	 
	static private function relaygetProduction($resource='')
	{
		$resinfo = self::GetResourceInfo($resource);
		
		list($sum_prod_base, $sum_bonus_base) = array(0,0);
		
		foreach($resinfo['dependencies'] as $dependency)
		{
			
			list($gran,$prodbase,$prodquo) = array($dependency['granularity'],$dependency['production_base'],$dependency['production_quotient']);
			list($effi,$bonbase,$bonquo) = array($dependency['efficiency'],$dependency['bonus_base'],$dependency['bonus_quotient']);
			list($ttype,$tname) = array($dependency['targettype'],$dependency['targetname']);
			
			switch($ttype)
			{
				case 'resource':
					$level = self::relaygetProduction($tname);
					break;
				case 'building':
					$level = self::getItemLevel($tname,'building');
					break;
				case 'technology':
					$level = self::getItemLevel($tname,'technology');
					break;
			}
			
			if ($prodquo != 0)
			{
				$sum_prod_base += $prodbase * pow($prodquo,floor(($level-1) / $gran)) * $effi;
			} else
			{
				$sum_prod_base += $prodbase * floor($level/$gran) * $effi;
			}
			
			if ($bonquo != 0)
			{
				$sum_bonus_base += $bonbase * pow($bonquo,floor(($level-1)/$gran));
			} else
			{
				$sum_bonus_base += $bonbase * floor($level/$gran);
			}
		}		
		return $sum_prod_base * (1 + $sum_bonus_base);
	}
	
	/**
	 * Part of the interface
	 */
	static public function getResourceTypes($type = array())
	{
		return array('fundamental','rating');
	}
	
}
	
	

?>
