<?php

class Balloz_DeveloperToolbar_Model_BlockProfiler
{
    protected $creates = array();
    protected $profiles = array();
    protected $stack = array();
    protected $helper;
    protected $app;

    public function __construct()
    {
        $this->helper = Mage::helper('developertoolbar');
        $this->app = Mage::app();
    }

    protected function getQueryCounts() {
        $queries = array();

        foreach ($this->helper->getQueries() as $connection => $all) {
            $queries[$connection] = count($all);
        }

        return $queries;
    }

    protected function countQueries($entry) {
        $starts = $entry['query_start'];
        $ends = $entry['query_end'];
        $counts = array();

        foreach ($starts as $connection => $counts) {
            $counts[$connection] = $ends[$connection] - $counts;
        }

        return $counts;
    }

    public function onBlockCreation(Varien_Event_Observer $event)
    {
        $block = $event->getBlock();
        $name = $block->getNameInLayout();

        $this->creates[] = array(
            'name' => $name,
            'queries' => $this->getQueryCounts()
        );
    }

    public function beforeBlockRender(Varien_Event_Observer $event) {
        $block = $event->getBlock();
        $this->stack[] = array(
            'level' => count($this->stack),
            'name' => $block->getNameInLayout(),
            'class' => get_class($block),
            'query_start' => $this->getQueryCounts(),
            'start' => microtime(true),
            'profile_index' => count($this->profiles)
        );
        $this->profiles[] = array();
    }

    public function afterBlockRender(Varien_Event_Observer $event) {
        $block = $event->getBlock();

        if (count($this->stack) === 0) {
            throw new Exception('Stack should not be empty!');
        }

        $entry = array_pop($this->stack);
        $entry['query_end'] = $this->getQueryCounts();
        $entry['end'] = microtime(true);

        $servedFromCache = (bool)$this->app->loadCache($block->getCacheKey());

        $this->profiles[$entry['profile_index']] = array(
            'level' => $entry['level'],
            'name' => $entry['name'],
            'class' => $entry['class'],
            'query_count' => $entry['query_end']['core_read'] - $entry['query_start']['core_write'],
            'duration' => 1000 * ($entry['end'] - $entry['start']),
            'served_from_cache' => $servedFromCache
        );
    }

    public function getCreates() {
        return $this->creates;
    }

    public function getProfiles() {
        return array_filter($this->profiles);
    }
}
