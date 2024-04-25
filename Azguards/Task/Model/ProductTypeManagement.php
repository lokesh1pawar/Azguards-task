<?php
/**
 * Created By : Lokesh Pawar
 */

namespace Azguards\Task\Model;

use Azguards\Task\Api\ProductTypeManagementInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Eav\Model\Config;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductTypeManagement implements ProductTypeManagementInterface
{
    protected $productRepository;
    protected $eavConfig;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        Config $eavConfig
    ) {
        $this->productRepository = $productRepository;
        $this->eavConfig = $eavConfig;
    }

    public function setProductType($sku, $customProductType)
    {
        try {
            $product = $this->productRepository->get($sku);
            $attribute = $this->eavConfig->getAttribute('catalog_product', 'custom_product_type');
            if ($attribute->usesSource()) {
                $customProductTypeId = $attribute->getSource()->getOptionId($customProductType);
                if ($customProductTypeId) {
                    $product->setCustomAttribute('custom_product_type', $customProductTypeId);
                } else {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('The custom product type value is not valid.')
                    );
                }
            }

            $this->productRepository->save($product);

            // Check if the custom attribute is saved in the DB
            $savedProduct = $this->productRepository->get($sku, false, null, true); 
            $savedProductType = $savedProduct->getCustomAttribute('custom_product_type');

            if ($savedProductType && $savedProductType->getValue() == $customProductTypeId) {
                return "Product type updated successfully";
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Failed to update product type.')
                );
            }
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(__('Product with SKU "%1" does not exist.', $sku));
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
        }
    }
}