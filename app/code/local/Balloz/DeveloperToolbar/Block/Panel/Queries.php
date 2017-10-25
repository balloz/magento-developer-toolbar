<?php

class Balloz_DeveloperToolbar_Block_Panel_Queries extends Balloz_DeveloperToolbar_Block_Panel
{
    public function getIdentifier()
    {
        return 'queries';
    }

    public function getName()
    {
        return 'Queries';
    }

    public function prettyInterval($interval)
    {
        if ($interval < 10) {
            $className = 'green';
        } elseif ($interval < 20) {
            $className = 'yellow';
        } else {
            $className = 'red';
        }

        return '<span class="query-interval '.$className.'">'.number_format($interval, 2).'ms</span>';
    }

    public function getQueries()
    {
        return $this->helper('developertoolbar')->getQueries();
    }
}
