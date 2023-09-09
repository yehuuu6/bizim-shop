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
        $body = <<<HTML
        <div class="product">
            <div class="product-image"> 
                <img src="{$this->get_image_src($product)}" alt="Product Image">
                <div class="product-info">
                <div class="product-name">
                    <h3>{$product["name"]}</h3>
                </div>
                <div class="product-price">
                    <h3>₺{$product['price']}</h3>
                </div>
                <div class="product-description">
                    <p>{$product['description']}</p>
                </div>
                <div class="product-buttons">
                    <button class="add-to-cart">Add to Cart</button>
                    <button class="view-product">View Details</button>
                </div>
            </div>
            </div>
        </div>
        HTML;

        // Render the component on the page
        $this->render($body);
    }
    private function get_image_src(array $product)
    {
        if ($product['image1'] === "noimg.jpg") {
            $image_src = PRODUCT_IMAGE_SITE_PATH . "noimg.jpg";
        } else {
            $image_src = PRODUCT_IMAGE_SITE_PATH . "{$product['root_name']}/{$product['image1']}";
        }
        return $image_src;
    }
}
