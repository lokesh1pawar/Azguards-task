<?php
/**
 * Created By : Lokesh Pawar
 */

namespace Azguards\Task\Plugin;

use Magento\Catalog\Block\Product\View\Gallery;
use Magento\Framework\Data\Collection;
use Magento\Framework\Data\CollectionFactory;
use Magento\Framework\DataObject;
use Magento\Catalog\Model\Product;

class ChangeProductImageUrl
{
    /**
     * @var CollectionFactory
     */
    protected $dataCollectionFactory;

    /**
     * ChangeProductImageUrl constructor.
     *
     * @param CollectionFactory $dataCollectionFactory
     */
    public function __construct(
        CollectionFactory $dataCollectionFactory
    ) {
        $this->dataCollectionFactory = $dataCollectionFactory;
    }

    /**
     *
     * @param Gallery $subject
     * @param Collection|null $images
     * @return Collection|null
     */
    public function afterGetGalleryImages(Gallery $subject, $images)
    {
        $product = $subject->getProduct();

        // Check if the product 'Product Type' attribute is set to 'Custom'
        if ($product && $product->getCustomAttribute('custom_product_type') && $product->getCustomAttribute('custom_product_type')->getValue() == '2') {
            $productName = $product->getName();
            $images = $this->dataCollectionFactory->create();
            $externalImage = "https://images.pexels.com/photos/270348/pexels-photo-270348.jpeg";
            $imageData = [
                'file' => $externalImage,
                'media_type' => 'image',
                'value_id' => uniqid(),
                'row_id' => uniqid(),
                'label' => $productName,
                'label_default' => $productName,
                'position' => 1,
                'position_default' => 1,
                'disabled' => 0,
                'url' => $externalImage,
                'path' => '',
                'small_image_url' => $externalImage,
                'medium_image_url' => $externalImage,
                'large_image_url' => $externalImage
            ];

            $images->addItem(new DataObject($imageData));
        }

        return $images;
    }
}