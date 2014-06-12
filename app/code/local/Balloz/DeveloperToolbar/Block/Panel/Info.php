<?php

class Balloz_DeveloperToolbar_Block_Panel_Info extends Balloz_DeveloperToolbar_Block_Panel
{
    public function getIdentifier()
    {
        return 'info';
    }

    public function getName()
    {
        return 'Info';
    }

    public function getInfo()
    {
        $info = array();

        $info['Store code'] = Mage::app()->getStore()->getCode();
        $info['Website code'] = Mage::app()->getWebsite()->getCode();

        return $info;
    }
}
