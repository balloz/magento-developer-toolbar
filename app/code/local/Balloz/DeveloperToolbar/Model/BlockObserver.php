<?php
class Balloz_DeveloperToolbar_Model_BlockObserver{
	const HEAD_NAME = "head";
	const BALLOZ_NAME = "balloz.toolbar";
	const START_CLASS_SUFFIX = "-start-viewer";
	const END_CLASS_SUFFIX = "-end-viewer";
	const GLOBAL_CLASS = "developer-toolbar-dom-marker";
	
	protected $_excludedModules;
	
	public function wrapBlocks($observer){
		$transport = $observer->getTransport();
		$block = $observer->getBlock();
		$blockName = $block->getNameInLayout();
		
		if($this->_isForbidden($block) || $block->getIsAnonymous() || $blockName == 'root'){
			return;
		}
		
		if($transport->getHtml()){
			$transport->setHtml("<div class='" . $this->_makeStartClass($blockName) . "'></div>" . $transport->getHtml() . "<div class='" . $this->_makeEndClass($blockName)  . "'></div>");
		}
	}
	
	protected function _getExcludedModules(){
		if($this->_excludedModules){
			return $this->_excludedModules;
		}
		
		$this->_excludedModules = explode(",",Mage::getStoreConfig('developertoolbar/settings/exclusions'));
		return $this->_excludedModules;
	}
	
	protected function _isForbidden($block, $forbidden = array(self::HEAD_NAME, self::BALLOZ_NAME)){
		if(!$block){
			return false;
		}
		
		if(in_array($block->getNameInLayout(), $forbidden)){
			return true;
		}
		
		if(in_array($block->getModuleName(), $this->_getExcludedModules())){
			return true;
		}
		
		if(Mage::getStoreConfig('developertoolbar/settings/excludeforajax') && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
			return true;
		}
		
		return $this->_isForbidden($block->getParentBlock());
	}
	
	protected function _makeStartClass($blockName){
		$helper = Mage::helper('developertoolbar');
		return $helper->makeLayoutNameIntoClass($blockName) . self::START_CLASS_SUFFIX . " " . self::GLOBAL_CLASS;
	}
	
	protected function _makeEndClass($blockName){
		$helper = Mage::helper('developertoolbar');
		return $helper->makeLayoutNameIntoClass($blockName) . self::END_CLASS_SUFFIX . " " . self::GLOBAL_CLASS;
	}
}