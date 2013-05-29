<?php

class Balloz_DeveloperToolbar_Block_Panel extends Mage_Core_Block_Template
{
    public function setName($name)
    {
        $this->setData('name', $name);
    }

    public function getName()
    {
        return $this->getData('name');
    }
}
