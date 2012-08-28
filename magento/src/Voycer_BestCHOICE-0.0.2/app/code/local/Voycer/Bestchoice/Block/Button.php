<?php

/**
 * Besthchoice Extension for Magento created by Voycer AG
 * Get Bestchoice at http://www.voycer.biz/en/bestchoice
 *
 * @category  Voycer
 * @package   Voycer_Bestchoice_Block_Button
 * @copyright Copyright (c) 2012 Voycer AG. (http://www.voycer.biz)
 */
class Voycer_Bestchoice_Block_Button extends Mage_Core_Block_Template
{
    /**
     * @var Mage_Catalog_Model_Product
     */
    protected $product;

    /**
     * @param Mage_Catalog_Model_Product $product
     */
    public function setProduct(Mage_Catalog_Model_Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Mage_Catalog_Model_Product|null
     */
    public function getProduct()
    {
        if ($this->product === null) {
            /* @var $product Mage_Catalog_Model_Product */
            $product = Mage::registry('current_product');

            if (! ($product instanceof Mage_Catalog_Model_Product)) {
                return null;
            }

            $this->product = $product;
        }

        return $this->product;
    }

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

        if (null === ($product = $this->getProduct())) {
            return '';
        }

        $apiKey = Mage::getStoreConfig(Voycer_Bestchoice_Helper_Data::XML_PATH_API_KEY, Mage::app()->getStore());
        $apiSecret = Mage::getStoreConfig(Voycer_Bestchoice_Helper_Data::XML_PATH_API_SECRET, Mage::app()->getStore());
        $attributesConfig = Mage::getStoreConfig(Voycer_Bestchoice_Helper_Data::XML_PATH_ATTRIBUTES, Mage::app()->getStore());

        $productHash = array (
            "product_id"       => array("type" => "string",
                                        "value" => $product->getId()),
            "product_name"     => array("type" => "text",
                                        "value" => $product->getName()),
            "product_price"    => array("type" => "number",
                                        "value" => Zend_Locale_Format::toNumber($product->getFinalPrice(),
                                                   array('precision' => 2, 'locale' => Mage::app()->getLocale()->getLocaleCode()))),
            "product_currency" => array("type" => "text",
                                        "value" => Mage::app()->getStore()->getCurrentCurrencyCode()),
            "product_image"    => array("type" => "url",
                                        "value" => (string) Mage::helper('catalog/image')->init($product, 'thumbnail')),
            "product_url"      => array("type" => "url",
                                        "value" => $product->getProductUrl(false)),
        );

        $additionalAttributes = array();
        $attributeSetModel = Mage::getModel("eav/entity_attribute_set");
        $attributeSetModel->load($product->getAttributeSetId());
        $attributeSetName  = $attributeSetModel->getAttributeSetName();
        $lines = explode("\n", $attributesConfig);


        foreach ($lines as $line) {
            $line = explode(":", $line);
            if (sizeof($line) < 1) {
                continue;
            }

            $category = trim($line[0]);
            $line = trim($line[1]);

            if ($attributeSetName !== $category) {
                continue;
            }

            $attributes = explode(",", $line);

            foreach ($attributes as $attribute) {
                $attribute = trim($attribute);

                $additionalAttributes[$attribute] = array("type" => "text",
                                                          "value" => Mage::getResourceModel('catalog/product')->
                                                                         getAttributeRawValue($product->getId(),
                                                                                              $attribute,
                                                                                              $product->getStoreId()));
            }
        }

        $productHash = array_merge($productHash, $additionalAttributes);

        foreach ($productHash as $key => $value) {
            $productHash[$key]['csrf'] = md5($value['value'] . $apiSecret);
        }

        if (sizeof($additionalAttributes) > 0) {
            $productHash['product_template'] = str_replace(" ", "_", strtolower($attributeSetName));
        }

        $this->assign('css', $bestchoice->getAdditionalCssClass());
        $this->assign('hasCount', $bestchoice->hasCount());
        $this->assign('product', json_encode($productHash, JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT));

        return parent::_toHtml();
    }
}
