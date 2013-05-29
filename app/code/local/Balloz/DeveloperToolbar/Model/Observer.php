<?php

class Balloz_DeveloperToolbar_Model_Observer
{
    public function enableProfiling(Varien_Event_Observer $event)
    {
        if (!Mage::helper('developertoolbar')->isEnabledForCurrentIp()) {
            return;
        }

        // TODO: Enable/disable based on config setting? Perhaps cookie set by frontend toolbar?
        Varien_Profiler::enable();

        // Enable query profiling on read + write connection
        $resource = Mage::getSingleton('core/resource');

        $resource->getConnection('core_write')
            ->getProfiler()->setEnabled(true);

        $resource->getconnection('core_read')
            ->getProfiler()->setEnabled(true);
    }
}
