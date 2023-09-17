<?php

namespace Components\Product;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Cart Item component
 */
class CartItem extends Component
{
  public $body;
  public function __construct(array $product)
  {
    $product['shipment'] === '1' ? $shipping_cost = 0 : $shipping_cost = $product['shipping_cost'];
    $shipping_cost = number_format($shipping_cost, 2);

    $fee_cost = $product['price'] * 0.18;
    $fee_cost = number_format($fee_cost, 2);

    $total_price = $product['price'] + $shipping_cost + $fee_cost;

    $short_desc = parent::shorten_string($product['description'], 100);

    $slug = parent::get_slug($product['root_name']);

    $this->body = <<<HTML
        <div class="product-in-cart" data-id="{$product['id']}">
            {$this->render_shipment_element($product)}
            <div class="product-image">
              <img
                src="{$this->get_image_src($product)}"
                alt="Resim"
              />
            </div>
            <div class="product-info">
              <a href="/product/{$slug}" class="product-title">{$product['name']}</a>
              <p class="product-desc">
                {$short_desc}
              </p>
              <div class="price-calculation">
                <span data-value="{$product['price']}" class="product-price">{$product['price']} <span class="product-currency">TL</span> Ürün</span> +
                <span data-value="{$shipping_cost}" class="shipping-cost">{$shipping_cost} <span class="product-currency">TL</span> Kargo</span> + 
                <span data-value="{$fee_cost}" class="fee-cost">{$fee_cost} <span class="product-currency">TL</span> KDV</span> =
                <span id="total-cart-price" data-value="{$total_price}" class="total-price">{$total_price} <span class="product-currency">TL</span> Toplam</span>
              </div>
            </div>
            <span class="remove-from-cart" title="Ürünü Sepetten Sil">
            <i class="fa-solid fa-trash"></i>
            </span>
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
