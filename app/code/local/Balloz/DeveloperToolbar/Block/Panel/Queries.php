<?php

class Balloz_DeveloperToolbar_Block_Panel_Queries extends Balloz_DeveloperToolbar_Block_Panel
{
	protected $connections = array(
		'core_read',
		'core_write'
	);

	public function getIdentifier() {
		return 'queries';
	}

	public function getName() {
		return 'Queries';
	}

	public function getQueries() {
		$queries = array();
		$resource = Mage::getSingleton('core/resource');

		foreach ($this->connections as $connection) {
			$queries[$connection] = $resource->getConnection($connection)->getProfiler()->getQueryProfiles();
		}

		return $queries;
	}
}
