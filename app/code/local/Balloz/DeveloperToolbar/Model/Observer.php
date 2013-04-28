<?php

class Balloz_DeveloperToolbar_Model_Observer
{
	public function enableProfiling(Varien_Event_Observer $event) {
		// TODO: Enable/disable based on config setting? Perhaps cookie set by frontend toolbar?
		Varien_Profiler::enable();
	}
}
