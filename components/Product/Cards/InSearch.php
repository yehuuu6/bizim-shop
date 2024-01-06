<?php

namespace Components\Product\Cards;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Search Product Item component
 */
class InSearch extends Component
{
  public $body;
  public function __construct(array $product)
  {
    $slug = parent::get_slug($product['root_name']);

    $slug = urlencode(urlencode($slug));

    $error_src = PRODUCT_IMAGE_SITE_PATH . "noimg.jpg";

    $this->body = <<<HTML
        <div class="product-in-search dynamic-content" data-id="{$product['id']}">
            <div class="product-image">
              <img
                src="{$this->get_image_src($product)}"
                alt="Resim"
                onerror='this.src="{$error_src}"'
                loading="lazy"
              />
            </div>
            <div class="product-info">
              <a href="/product/{$slug}" class="product-title">{$product['name']}</a>
              <div class="price-calculation">
                <span data-value="{$product['price']}" class="product-price">{$product['price']} <span class="product-currency">TL</span></span>
              </div>
            </div>
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
}
