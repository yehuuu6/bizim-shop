<?php

namespace Components\Product;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Search Product Item component
 */
class SearchItem extends Component
{
  public $body;
  public function __construct(array $product)
  {
    $slug = parent::get_slug($product['root_name']);

    $error_src = PRODUCT_IMAGE_SITE_PATH . "noimg.jpg";

    $this->body = <<<HTML
        <div class="product-in-cart" data-id="{$product['id']}">
            {$this->render_shipment_element($product)}
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
                <span data-value="{$product['price']}" class="product-price">{$product['price']} <span class="product-currency">TL</span> Ürün</span>
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
  /**
   * Renders 'Free Shipment' element if the product has free shipment.
   * @param array $product The product to check if it has free shipment.
   * @return html $body
   */
  private function render_shipment_element(array $product)
  {
    if ($product['shipment'] === '1') {
      $body = <<<HTML
                <span class="free-shipment" title="Ücretsiz Kargo!">
                    <i class="fa-solid fa-truck"></i>
                </span>
            HTML;
    } else {
      $body = '';
    }

    return $body;
  }
}
