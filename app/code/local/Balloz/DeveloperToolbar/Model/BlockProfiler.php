<?php

class Balloz_DeveloperToolbar_Model_BlockProfiler
{
    protected $creates = array();
    protected $profiles = array();
    protected $stack = array();
    protected $helper;

    public function __construct()
    {
        $this->helper = Mage::helper('developertoolbar');
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
        if (count($this->stack) === 0) {
            throw new Exception('Stack should not be empty!');
        }

        $entry = array_pop($this->stack);
        $entry['query_end'] = $this->getQueryCounts();
        $entry['end'] = microtime(true);

        $this->profiles[$entry['profile_index']] = array(
            'level' => $entry['level'],
            'name' => $entry['name'],
            'class' => $entry['class'],
            'query_count' => $entry['query_end']['core_read'] - $entry['query_start']['core_write'],
            'duration' => 1000 * ($entry['end'] - $entry['start'])
        );
    }

    public function getCreates() {
        return $this->creates;
    }

    public function getProfiles() {
        return array_filter($this->profiles);
    }

//
//    public function onBlockCreation(Varien_Event_Observer $event)
//    {
//        $block = $event->getBlock();
//        $name = $block->getNameInLayout();
//
//        if (!isset($this->blockQueries[$name])) {
//            $this->blockQueries[$name] = array();
//        }
//
//        $data = array();
//        foreach ($this->helper->getQueries() as $connection => $queries) {
//            $data[$connection] = array(
//                'creation' => count($queries),
//                'start' => false,
//                'end' => false
//            );
//        }
//
//        $this->blockQueries[$name][spl_object_hash($block)] = array(
//            'creation' => count($queries),
//            'entries' => array()
//        );
//    }
//
//    public function beforeBlockRender(Varien_Event_Observer $event)
//    {
//        $block = $event->getBlock();
//        $name = $block->getNameInLayout();
//        $hash = spl_object_hash($block);
//
//        foreach ($this->helper->getQueries() as $connection => $queries) {
//            if (isset($this->blockQueries[$name][$hash][$connection])) {
//                $index = max(0, count($this->blockQueries[$name][$hash][$connection]) - 1);
//            } else {
//                $index = 0;
//            }
//
//            echo 'START: ', get_class($block), "\n";
//
//            if (isset($this->blockQueries[$name][$hash][$connection][$index]['start'])) {
//                var_dump($block); die();
//                throw new Exception('This should not happen');
//            }
//
//            $this->blockQueries[$name][$hash][$connection][$index] = array(
//                'start' => count($queries)
//            );
//        }
//    }
//
//    public function afterBlockRender(Varien_Event_Observer $event)
//    {
//        $block = $event->getBlock();
//        $name = $block->getNameInLayout();
//        $hash = spl_object_hash($block);
//
//        foreach ($this->helper->getQueries() as $connection => $queries) {
//            $index = max(0, count($this->blockQueries[$name][$hash][$connection]) - 1);
//
//            echo 'END: ', get_class($block), "\n";
//
//            if (isset($this->blockQueries[$name][$hash][$connection][$index]['end'])) {
//                throw new Exception('This should not happen');
//            }
//
//            $this->blockQueries[$name][$hash][$connection][$index]['end'] = count($queries);
//        }
//    }
}