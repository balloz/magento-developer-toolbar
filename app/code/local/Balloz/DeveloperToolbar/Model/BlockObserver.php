<?php
class Balloz_DeveloperToolbar_Model_BlockObserver{
	const HEAD_NAME = "head";
	const BALLOZ_NAME = "balloz.toolbar";
	const START_CLASS_SUFFIX = "-start-viewer";
	const END_CLASS_SUFFIX = "-end-viewer";
	const GLOBAL_CLASS = "developer-toolbar-dom-marker";
	
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
	
	protected function _isForbidden($block, $forbidden = array(self::HEAD_NAME, self::BALLOZ_NAME)){
		if(!$block){
			return false;
		}
		
		if(in_array($block->getNameInLayout(), $forbidden)){
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