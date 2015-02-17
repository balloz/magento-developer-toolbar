<?php

class Balloz_DeveloperToolbar_Model_Observer
{
    const JQUERY_PATH = 'developertoolbar/jquery-1.11.2.min.js';
    const JQUERY_NOCONFLICT_PATH = 'developertoolbar/jquery-noconflict.js';
    const TOOLBAR_JS = 'js/balloz/developer-toolbar/toolbar.js';
    
    public function enableProfiling(Varien_Event_Observer $event)
    {
        if (!Mage::helper('developertoolbar')->isEnabledForCurrentIp()) {
            return;
        }

        // TODO: Enable/disable based on config setting? Perhaps cookie set by frontend toolbar?
        Varien_Profiler::enable();

        // Enable query profiling on read + write connection
        $resource = Mage::getSingleton('core/resource');

        $resource->getConnection('core_write')
            ->getProfiler()->setEnabled(true);

        $resource->getconnection('core_read')
            ->getProfiler()->setEnabled(true);
    }
    
    /* Woah, don't hate me for doing it this way... Cha cha cha! */
    public function addRequiredElements(){
        $layout = Mage::app()->getLayout();
        $helper = Mage::helper('developertoolbar');
        $insertBlock = $layout->getBlock('head');
        $loadjQuery = $helper->shouldLoadJquery();
        
        // Load the javascript into an alternate block if set, but keep to head for admin
        if(Mage::app()->getStore()->isAdmin()){
            $loadJquery = $helper->shouldLoadJqueryInAdmin();
        }else{
            if($helper->shouldLoadInAlternate()){
                $insertBlock = $helper->getAlternateBlock();
            }
        }
        
        if($insertBlock){
            if($loadJquery){
                $insertBlock->addJs(self::JQUERY_PATH);
                $insertBlock->addJs(self::JQUERY_NOCONFLICT_PATH);
            }
            
            $insertBlock->addItem('skin_js', 
                self::TOOLBAR_JS,
                "name='last'"
            );
        }
    }
}
