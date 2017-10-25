<?php

class Balloz_DeveloperToolbar_Model_BlockObserver
{
    const HEAD_NAME = "head";
    const BALLOZ_NAME = "balloz.toolbar";
    const START_MARKER_SUFFIX = "-start-viewer";
    const END_MARKER_SUFFIX = "-end-viewer";
    const GLOBAL_MARKER = "developer-toolbar-dom-marker";

    protected $excludedModules;

    public function wrapBlocks($observer)
    {
        $transport = $observer->getTransport();
        $block = $observer->getBlock();
        $blockName = $block->getNameInLayout();

        if ($this->_isForbidden($block) || $block->getIsAnonymous() || $blockName == 'root') {
            return;
        }

        if ($transport->getHtml()) {
            $transport->setHtml("<!--" . $this->_makeStartMarker($blockName) . "-->" . $transport->getHtml() . "<!--" . $this->_makeEndMarker($blockName) . "-->");
        }
    }

    protected function _getExcludedModules()
    {
        if ($this->excludedModules) {
            return $this->excludedModules;
        }

        $this->excludedModules = explode(",", Mage::getStoreConfig('developertoolbar/settings/exclusions'));
        return $this->excludedModules;
    }

    protected function _isForbidden($block, $forbidden = array(self::HEAD_NAME, self::BALLOZ_NAME))
    {
        if (!$block) {
            return false;
        }

        if (in_array($block->getNameInLayout(), $forbidden)) {
            return true;
        }

        if (in_array($block->getModuleName(), $this->_getExcludedModules())) {
            return true;
        }

        if (Mage::getStoreConfig('developertoolbar/settings/excludeforajax')
            && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return true;
        }

        return $this->_isForbidden($block->getParentBlock());
    }

    protected function _makeStartMarker($blockName)
    {
        $helper = Mage::helper('developertoolbar');
        return $helper->makeLayoutNameIntoClass($blockName) . self::START_MARKER_SUFFIX . " " . self::GLOBAL_MARKER;
    }

    protected function _makeEndMarker($blockName)
    {
        $helper = Mage::helper('developertoolbar');
        return $helper->makeLayoutNameIntoClass($blockName) . self::END_MARKER_SUFFIX . " " . self::GLOBAL_MARKER;
    }
}