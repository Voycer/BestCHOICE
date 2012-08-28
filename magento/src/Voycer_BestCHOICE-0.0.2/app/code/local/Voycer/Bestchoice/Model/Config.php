<?php

/**
 * Besthchoice Extension for Magento created by Voycer AG
 * Get Bestchoice at http://www.voycer.biz/en/bestchoice
 *
 * @category  Voycer
 * @package   Voycer_Bestchoice_Model_Config
 * @copyright Copyright (c) 2012 Voycer AG. (http://www.voycer.biz)
 */
class Voycer_Bestchoice_Model_Config
{
    /**
     * Returns all css options
     *
     * @return array
     */
    public function getCssOptions()
    {
        return array(
            0 => Mage::helper('voycer_bestchoice')->__('none'),
            1 => 'vcrbc-icon-only',
        );
    }
}