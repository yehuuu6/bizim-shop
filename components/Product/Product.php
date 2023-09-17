<?php

namespace Components\Product;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Product component
 */
class Product extends Component
{
    public $body;
    public function __construct(array $product)
    {
        $product_title = parent::shorten_string($product['name'], 18);

        $is_featured = $product['featured'] == '1' ? true : false;

        $slug = parent::get_slug($product['root_name']);

        $this->body = <<<HTML
        <div class="product" data-id="{$product['id']}">
        {$this->render_featured_badge($is_featured)}
            <div class="product-image">
                <span class="add-wishlist" title="Favorilere Ekle"><i class="fa-regular fa-heart"></i></span>
                <img src="{$this->get_image_src($product)}" alt="Resim">
                {$this->render_shipment_element($product)}
            </div>
            <div class="product-info">
                <a title="{$product['name']}" href="/product/{$slug}" class="product-title">{$product_title}</a>
                <span class="product-price">{$product['price']} <span class="product-currency">TL</span></span>
            </div>
            <button id="product-cart-btn" class="add-cart">Sepete Ekle</button>
        </div>
        HTML;
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
     * @param array $product The product to check if it has free shipment.
     * @return html $body
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
     * Renders 'Featured' badge if the product is featured.
     * @param bool $is_featured The condition to check if the product is featured.
     * @return html $body
     */
    private function render_featured_badge(bool $is_featured)
    {
        if ($is_featured) {
            $body = <<<HTML
            <span class="featured-product" title="Öne Çıkan Ürün">
                <i class="fa-solid fa-star"></i>
            </span>
        HTML;
        } else {
            $body = '';
        }

        return $body;
    }
}
