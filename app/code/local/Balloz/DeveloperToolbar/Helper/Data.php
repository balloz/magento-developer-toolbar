<?php

class Balloz_DeveloperToolbar_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $ips = null;

    public function isEnabledForIp($ip) {
        if ($this->ips === null) {
            $this->ips = array_filter(
                explode(',', Mage::getStoreConfig('developertoolbar/settings/ips'))
            );
        }

        return empty($this->ips) || in_array($ip, $this->ips);
    }

    public function isEnabledForCurrentIp() {
        $ip = Mage::helper('core/http')->getRemoteAddr();

        return $this->isEnabledForIp($ip);
    }
}
