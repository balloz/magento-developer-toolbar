<?php

class Balloz_DeveloperToolbar_Block_Panel_Debug extends Balloz_DeveloperToolbar_Block_Panel
{
    public function getIdentifier()
    {
        return 'debug';
    }

    public function getName()
    {
        return 'Debug';
    }

    public function getAll() {
        return Mage::getSingleton('developertoolbar/debug')->getAll();
    }

    public function hasAny() {
        return Mage::getSingleton('developertoolbar/debug')->hasAny();
    }
}
