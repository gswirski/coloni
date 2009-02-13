<?php

$this->dispatcher->connect('user.activate', array('Country', 'onActivateCreateNew'));
$this->dispatcher->connect('settlement.building_level', array('coSettlementBuildings', 'levelFilter'));