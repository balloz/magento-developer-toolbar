<?php

class Balloz_DeveloperToolbar_Block_Panel_Handles extends Balloz_DeveloperToolbar_Block_Panel
{
    public function getIdentifier()
    {
        return 'handles';
    }

    public function getName()
    {
        return 'Handles';
    }

    public function getLayoutHandles()
    {
        return $this->getLayout()->getUpdate()->getHandles();
    }
}
