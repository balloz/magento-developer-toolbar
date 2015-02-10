<?php

class Balloz_DeveloperToolbar_Model_Debug
{
    protected $debug = array();

    public function add($data, $name = false) {
        $this->debug[] = array(
            'name' => $name ?: 'Debug',
            'data' => $data
        );
    }

    public function getAll() {
        return $this->debug;
    }

    public function hasAny() {
        return !empty($this->debug);
    }
}