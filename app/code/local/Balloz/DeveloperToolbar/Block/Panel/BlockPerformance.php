<?php

class Balloz_DeveloperToolbar_Block_Panel_BlockPerformance extends Balloz_DeveloperToolbar_Block_Panel
{
    public function getIdentifier()
    {
        return 'block-performance';
    }

    public function getName()
    {
        return 'Block Performance';
    }

    public function getProfiles()
    {
        return Mage::getSingleton('developertoolbar/blockProfiler')->getProfiles();
    }

    public function colorInterval($interval)
    {
        if ($interval < 5) {
            return 'notify-green';
        } elseif ($interval < 10) {
            return 'notify-yellow';
        } else {
            return 'notify-red';
        }
    }

    public function colorQueries($queries) {
        if ($queries < 5) {
            return 'notify-green';
        } elseif ($queries < 15) {
            return 'notify-yellow';
        } else {
            return 'notify-red';
        }
    }
}