<?php

/**
 * Besthchoice Extension for Magento created by Voycer AG
 * Get Bestchoice at http://www.voycer.biz/en/bestchoice
 *
 * @category  Voycer
 * @package   Voycer_Bestchoice_Block_Js
 * @copyright Copyright (c) 2012 Voycer AG. (http://www.voycer.biz)
 */
class Voycer_Bestchoice_Block_Js extends Mage_Core_Block_Template
{
    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        /* @var $bestchoice Voycer_Bestchoice_Helper_Data */
        $bestchoice = Mage::helper('voycer_bestchoice');

        if (! $bestchoice->isVoycerBestchoiceEnabled()) {
            return '';
        }

        $baseUrl = Mage::getStoreConfig(Voycer_Bestchoice_Helper_Data::XML_PATH_BASEURL, Mage::app()->getStore());
        $apiKey  = Mage::getStoreConfig(Voycer_Bestchoice_Helper_Data::XML_PATH_API_KEY, Mage::app()->getStore());
        $locale  = Mage::app()->getLocale()->getLocaleCode();

        $this->assign('baseUrl', $baseUrl);
        $this->assign('apiKey', $apiKey);
        $this->assign('locale', $locale);

        return parent::_toHtml();
    }
}
