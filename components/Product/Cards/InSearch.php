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
    $guid = $product['guid'];

    $error_src = PRODUCT_IMAGE_SITE_PATH . "noimg.jpg";

    $fee_cost = $product['price'] * KDV;
    $fee_cost = number_format($fee_cost, 2, '.', '');

    $total_price = (float)$product['price'] + (float)$fee_cost;

    // Convert the total price to a readable number.
    $price = readable_num($total_price);

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
            <div class="product-info" style="align-items:flex-start;">
              <a href="/product/{$guid}" class="product-title">{$product['name']}</a>
              <div class="price-calculation">
                <span class="product-price">{$price} <span class="product-currency">TL</span></span>
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
