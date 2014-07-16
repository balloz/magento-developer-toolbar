<?php

class Balloz_DeveloperToolbar_Block_Panel_Javascript extends Balloz_DeveloperToolbar_Block_Panel
{
    public function getIdentifier()
    {
        return 'javascript';
    }

    public function getName()
    {
        return 'Javascript';
    }
	
	public function getSkinJs()
	{
		return $this->getItems('skin_js');
		
	}
	
	public function getRootJs()
	{
		return $this->getItems('js');
		
	}

    public function getItems($type)
    {
		$blocks = Mage::app()->getLayout()->getAllBlocks();
		$allItems = array();
		
		foreach($blocks as $block){
			if($block->getType() == "page/html_head"){
				foreach($block->getItems() as $item){
					if($item['type'] == $type){
						$allItems[] = $item['name'];
					}
				}
			}
		}

		return $allItems;
    }
}
