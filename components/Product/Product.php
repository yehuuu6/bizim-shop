<?php

namespace Components\Product;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Product component
 */
class Product extends Component
{
    public function __construct(array $product)
    {
        $product_title = parent::shorten_string($product['name'], 15);
        $body = <<<HTML
        <div class="product" data-id="{$product['id']}">
            <div class="product-image">
                {$this->render_wishlist_element(false)}
                <img src="{$this->get_image_src($product)}" alt="Resim">
                {$this->render_shipment_element($product)}
            </div>
            <div class="product-info">
                <a title="{$product['name']}" href="#" class="product-title">{$product_title}</a>
                <span class="product-price">₺{$product['price']}</span>
            </div>
            <button class="add-cart">Sepete Ekle</button>
        </div>
        HTML;

        // Render the component on the page
        parent::render($body);
    }
    /**
     * Gets the image source of the product.
     * @param array $product The product to get the image source.
     * @return string
     */
    private function get_image_src(array $product)
    {
        if ($product['image1'] === "noimg.jpg") {
            $image_src = PRODUCT_IMAGE_SITE_PATH . "noimg.jpg";
        } else {
            $image_src = PRODUCT_IMAGE_SITE_PATH . "{$product['root_name']}/{$product['image1']}";
        }
        return $image_src;
    }
    /**
     * Renders 'Free Shipment' element if the product has free shipment.
     */
    private function render_shipment_element(array $product)
    {
        if ($product['shipment'] === '1') {
            $body = <<<HTML
                <span class="free-shipment">
                    <p>Ücretsiz Kargo</p>
                </span>
            HTML;
        } else {
            $body = '';
        }

        return $body;
    }
    /**
     * Renders 'Add to wishlist' element and 'Remove from wishlist' element based on if the user has added the product to wishlist.
     */
    private function render_wishlist_element(bool $condition)
    {
        // TODO Get if user has added the product to wishlist and set $condition based on that.
        if (!$condition) {
            $body = <<<HTML
            <span class="add-wishlist" title="Favorilere Ekle">
                <i class="fa-solid fa-heart"></i>
            </span>
        HTML;
        } else {
            $body = <<<HTML
            <span class="add-wishlist" title="Favorilerden Çıkar">
                <i class="fa-solid fa-heart-broken"></i>
            </span>
        HTML;
        }

        return $body;
    }
}
