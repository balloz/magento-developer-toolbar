<?php

class Balloz_DeveloperToolbar_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $ips = null;

    public function isEnabledForIp($ip)
    {
        if ($this->ips === null) {
            $this->ips = array_filter(
                explode(',', Mage::getStoreConfig('developertoolbar/settings/ips'))
            );
        }

        return empty($this->ips) || in_array($ip, $this->ips);
    }

    public function isEnabledForCurrentIp()
    {
        $ip = Mage::helper('core/http')->getRemoteAddr();

        return $this->isEnabledForIp($ip);
    }

    public function debug($data, $name = false) 
    {
        Mage::getSingleton('developertoolbar/debug')->add($data, $name);
    }

    public function makeLayoutNameIntoClass($name)
    {
        return str_replace('.', '-', $name);
    }

    public function shouldLoadJQuery()
    {
        return Mage::getStoreConfig('developertoolbar/settings/loadjquery');
    }

    public function shouldLoadInAlternate()
    {
        return Mage::getStoreConfig('developertoolbar/settings/loadinalternate');
    }

    public function shouldLoadJqueryInAdmin()
    {
        return Mage::getStoreConfig('developertoolbar/settings/loadjqueryinadmin');
    }

    public function getAlternateBlock() 
    {
        $layout = Mage::app()->getLayout();
        return $layout->getBlock(Mage::getStoreConfig('developertoolbar/settings/alternateblock'));
    }
}
