<?php
/**
 * Main coResourcePlugin code
 * @package coResourcePlugin
 * @author Vanilla
 */
 
/**
 * Static class for important resource operations
 * @package coResourcePlugin
 */
class coResource
{
	/**
	 * Precached production.yml (cut at 'resources')
	 * @var array
	 */
	private static $res_conf = null;
	
	 
	/**
	 * Precaches production.yml in the class logic in case of multiple queries at same execution
	 */
	static private function precacheProductionConfiguration()
	{
		self::$res_conf = sfYaml::load(sfConfig::get('sf_config_dir').'/game/production.yml');
		self::$res_conf = self::$res_conf['resource'];	 	
	}
	
	/**
	 * Gets item(building/tech. ) level
	 * @param string $item item name
	 * @param string $type item type(building | technology | resource)
	 * @return int Item's level
	 */
	static private function getItemLevel($name,$type)
	{
		$eventName = ($type=='resource' ? 'resource_count' : $type.'_level');
		$levels = sfContext::getInstance()->getEventDispatcher()->filter(
				new sfEvent(new self, $eventName, array(
  										'name' => $name,
										)), array(0));
		return $levels->getReturnValue();
	}
	
	/**
	 * Returns production amount in some units after given resource name
	 * @param string $resource Name of resource
	 * @return float Production in some units
	 */
	static function getProduction($resource)
	{
		if (empty(self::$res_conf)) self::precacheProductionConfiguration();
		$res_conf = self::$res_conf[$resource];
		
		$summed_production = 0;
		$summed_bonus = 0;
		
		define('rs','resources');
		define('r','resource');
		define('rps','production_per_step');
		define('rbs','bonus_per_step');
		define('rss','step_size');
		
		if (isset($res_conf['resources']))			// non-Fundamental
		{	
			foreach ($res_conf[rs] as $rname => $resource)
			{
				foreach (self::getItemLevel($rname, r) as $lvl)
				{
					$summed_production += @$resource[rps]*$lvl / $resource[rss];
					$summed_bonus += @$resource[rbs]*$lvl / $resource[rss];
				}
			}
			return $summed_production * (1+$summed_bonus);
		}
												// so in this case resource is Fundamental
									// those defs are so I don't make spelling mistakes
		define('pp','production');
		define('ppq','production_quotient');
			define('b','building');
			define('t','technology');
			define('bs','buildings');
			define('ts','technologies');
		define('pb','bonus');
		define('pbq','bonus_quotient');
		
					// doing buildings	
		foreach ($res_conf[bs] as $bname => $building)
		{
			foreach (self::getItemLevel($bname, b) as $lvl)
			{
				if (@$building[ppq])
				{
					$summed_production += $building[pp] * pow($building[ppq], $lvl-1);				
				} else
				{
					$summed_production += @$building[pp] * $lvl;
				}
				if (@$building[pbq])
				{
					$summed_bonus += $building[pb] * pow($building[pbq],$lvl-1);
				} else
				{
					$summed_bonus += @$building[pb] * $lvl;
				}
			}
		}
				// doing technologies
		foreach ($res_conf[ts] as $tname => $technology)
		{
			foreach (self::getItemLevel($tname, t) as $lvl)
			{
				if (@$technology[ppq])
				{
					$summed_production += $technology[pp] * pow($technology[ppq], $lvl-1);				
				} else
				{
					$summed_production += @$technology[pp] * $lvl;
				}
				if (@$technology[pbq])
				{
					$summed_bonus += @$technology[pb] * pow($technology[pbq],$lvl-1);
				} else
				{
					$summed_bonus += $technology[pb] * $lvl;
				}
			}
		}
						
		
		return $summed_production * (1+$summed_bonus);
	}
}
	

?>
