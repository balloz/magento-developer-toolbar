<?php

class Balloz_DeveloperToolbar_Block_Panel_Timers extends Balloz_DeveloperToolbar_Block_Panel
{
    protected $timers;

    public function _construct()
    {
        parent::_construct();

        $this->timers = Varien_Profiler::getTimers();
    }

    public function getIdentifier()
    {
        return 'timers';
    }

    public function getName()
    {
        return 'Timers';
    }

    public function colorInterval($interval)
    {
        if ($interval < 5) {
            return 'interval-green';
        } elseif ($interval < 10) {
            return 'interval-yellow';
        } else {
            return 'interval-red';
        }
    }

    public function getTimers()
    {
        $timers = $this->timers;
        uasort($timers, function($a, $b) {
            return $a['sum'] < $b['sum'];
        });

        return $timers;
    }
}
