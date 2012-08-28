<?php

/**
 * Besthchoice Extension for Magento created by Voycer AG
 * Get Bestchoice at http://www.voycer.biz/en/bestchoice
 *
 * @category  Voycer
 * @package   Voycer_Bestchoice_Helper_Data
 * @copyright Copyright (c) 2012 Voycer AG. (http://www.voycer.biz)
 */
class Voycer_Bestchoice_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Config paths for using throughout the code
     */
    const XML_PATH_ACTIVE     = 'voycer/bestchoice/active';
    const XML_PATH_BASEURL    = 'voycer/bestchoice/baseUrl';
    const XML_PATH_API_KEY    = 'voycer/bestchoice/apiKey';
    const XML_PATH_API_SECRET = 'voycer/bestchoice/apiSecret';
    const XML_PATH_ATTRIBUTES = 'voycer/bestchoice/attributes';
    const XML_PATH_CSS        = 'voycer/bestchoice/css';
    const XML_PATH_HAS_COUNT  = 'voycer/bestchoice/hasCount';


    /**
     * Returns true, if the module is enables
     *
     * @param mixed $store
     * @return bool
     */
    public function isVoycerBestchoiceEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(static::XML_PATH_ACTIVE, $store);
    }

    /**
     * @param null $store
     * @return string
     */
    public function getAdditionalCssClass($store = null)
    {
        $option = Mage::getStoreConfigFlag(static::XML_PATH_CSS, $store);

        if ($option === 0) {
            return '';
        }

        $model = new Voycer_Bestchoice_Model_Config();
        $options = $model->getCssOptions();

        return $options[$option];
    }

    /**
     * Returns true, if the counter must be shown
     *
     * @param mixed $store
     * @return bool
     */
    public function hasCount($store = null)
    {
        return Mage::getStoreConfigFlag(static::XML_PATH_HAS_COUNT, $store);
    }
}
