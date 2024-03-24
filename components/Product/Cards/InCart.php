<?php

namespace Components\Product\Cards;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Cart Item component
 */
class InCart extends Component
{
  public $body;
  public function __construct(array $product)
  {
    $old_shipping_cost = number_format($product['shipping_cost'], 2, '.', '');
    $product['shipment'] === '1' ? $shipping_cost = 0 : $shipping_cost = $product['shipping_cost'];
    $shipping_cost = number_format($shipping_cost, 2, '.', '');
    $fee_cost = $product['price'] * 0.18;
    $fee_cost = number_format($fee_cost, 2, '.', '');

    $total_price = (float)$product['price'] + (float)$shipping_cost + (float)$fee_cost;

    // Convert the total price to a readable number.
    $total_text = readable_num($total_price);
    $fee_text = readable_num($fee_cost);
    $shipping_text = readable_num($shipping_cost);
    $price_text = readable_num($product['price']);

    $short_desc = parent::shorten_string($product['description'], 100);

    $slug = parent::get_slug($product['root_name']);

    $slug = urlencode(urlencode($slug));

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
              <p class="product-desc">
                {$short_desc}
              </p>
              <div class="price-calculation">
                <span data-value="{$product['price']}" class="product-price">{$price_text} <span class="product-currency">TL</span> Ürün</span> +
                <span {$this->render_old_price($old_shipping_cost,$shipping_cost)} data-value="{$shipping_cost}" class="shipping-cost" {$this->render_indicator($product)}>{$shipping_text} <span class="product-currency" {$this->render_indicator($product)}>TL</span> Kargo</span> + 
                <span data-value="{$fee_cost}" class="fee-cost">{$fee_text} <span class="product-currency">TL</span> KDV</span> =
                <span id="total-cart-price" data-value="{$total_price}" class="total-price">{$total_text} <span class="product-currency">TL</span> Toplam</span>
              </div>
            </div>
            <span class="remove-from-cart" title="Ürünü Sepetten Kaldır">
              <i class="fa-solid fa-trash"></i>
            </span>
          </div>
        HTML;
  }

  private function render_old_price($old_shipping_cost, $shipping_cost)
  {
    if ($old_shipping_cost != $shipping_cost) {
      $body = <<<HTML
      data-old-value="{$old_shipping_cost}"
      HTML;
    } else {
      $body = <<<HTML
      data-old-value="0"
      HTML;
    }
    return $body;
  }

  private function render_indicator($product)
  {
    if ($product['shipment'] === '1') {
      $body = <<<HTML
      style="color: #00b300;"
      HTML;
    } else {
      $body = '';
    }
    return $body;
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
