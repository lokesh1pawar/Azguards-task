<?php
/**
 * Created By : Lokesh Pawar
 */

namespace Azguards\Task\Api;

interface ProductTypeManagementInterface
{
    /**
     * Set product type by SKU
     *
     * @param string $sku
     * @param string $customProductType
     * @return \Magento\Catalog\Api\Data\ProductInterface
     */
    public function setProductType($sku, $customProductType);
}