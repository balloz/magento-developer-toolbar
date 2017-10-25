<?php

class Balloz_DeveloperToolbar_Block_Panel_Blocks extends Balloz_DeveloperToolbar_Block_Panel
{
    protected $timers;

    public function _construct()
    {
        parent::_construct();

        $this->timers = Varien_Profiler::getTimers();
    }

    public function getIdentifier()
    {
        return 'blocks';
    }

    public function getName()
    {
        return 'Blocks';
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

    protected function _buildEntries(&$entries, $block, $alias, $level)
    {
        $extras = array();
        $extras[] = count($block->getChild()) ? count($block->getChild()) : "-";
        $extras[] = $block->getType();

        if ($block->getType() === 'cms/block') {
            $extras[] = $block->getBlockId();
        } elseif ($block->getType() == 'cms/page') {
            $extras[] = $block->getPage()->getIdentifier();
        } elseif ($template = $block->getTemplate()) {
            $extras[] = $template;
        } else {
            $extras[] = '-';
        }

        $extras[] = get_class($block);

        // sprintf("$offset%s %s\n", $alias, $this->_colorize($extraString, self::COLOR_DARK_GRAY))
        $name = $block->getNameInLayout();
        $entry = array(
            'name' => $name,
            'alias' => $alias,
            'level' => $level,
            'extras' => $extras,
        );

        $profileName = "BLOCK: $name";
        if (isset($this->timers[$profileName])) {
            $entry['time'] = $this->timers[$profileName]['sum'] * 1000;
        }

        $entries[] = $entry;

        foreach ($block->getChild() as $alias => $childBlock) {
            $this->_buildEntries($entries, $childBlock, $alias, $level + 1);
        }
    }

    public function getEntries()
    {
        $layout = Mage::app()->getLayout();
        $root = $layout->getBlock('root');
        $entries = array();

        $this->_buildEntries($entries, $root, 'root', '', 0);

        return $entries;
    }
}
