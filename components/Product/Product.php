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
        $product_title = parent::shorten_string($product['name'], 18);
        $is_featured = $product['featured'] == '1' ? true : false;
        $body = <<<HTML
        <div class="product" data-id="{$product['id']}">
        {$this->render_featured_badge($is_featured)}
            <div class="product-image">
                {$this->render_wishlist_element(false)}
                <img src="{$this->get_image_src($product)}" alt="Resim">
                {$this->render_shipment_element($product)}
            </div>
            <div class="product-info">
                <a title="{$product['name']}" href="#" class="product-title">{$product_title}</a>
                <span class="product-price">₺{$product['price']}</span>
            </div>
            <div class="product-btns">
                {$this->render_add_to_cart_element(false)}
            </div>
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
     * Renders 'Add to wishlist' element and 'Remove from wishlist' element based on if the user has added the product to wishlist.
     * @param bool $condition The condition to check if the user has added the product to wishlist.
     * @return html $body
     */
    private function render_wishlist_element(bool $condition)
    {
        // TODO Get if user has added the product to wishlist and set $condition based on that.
        if (!$condition) {
            $body = <<<HTML
            <span class="add-wishlist" title="Favorilere Ekle">
                <i class="fa-regular fa-heart"></i>
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

    /**
     * Renders 'Add to cart' element and 'Remove from cart' element based on if the user has added the product to cart.
     * @param bool $condition The condition to check if the user has added the product to cart.
     * @return html $body
     */

    private function render_add_to_cart_element(bool $condition)
    {

        // TODO Get if user has added the product to the cart and set $condition based on that.
        if (!$condition) {
            $body = <<<HTML
            <button class="add-cart">Sepete Ekle</button>
        HTML;
        } else {
            $body = <<<HTML
            <button class="in-cart">Sepette</button>
        HTML;
        }

        return $body;
    }
}
