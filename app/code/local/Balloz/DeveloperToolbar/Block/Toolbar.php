<?php

class Balloz_DeveloperToolbar_Block_Toolbar extends Mage_Core_Block_Template
{
	public function getPanels() {
		if (!($panels = $this->getData('panels'))) {
			$panels = array();
			
			foreach ($this->_children as $name => $child) {
				if (!($child instanceof Balloz_DeveloperToolbar_Block_Panel)) {
					continue;
				}
				
				$panels[] = $child;
			}
			
			$this->setData('panels', $panels);
		}
		
		return $panels;
	}
}
