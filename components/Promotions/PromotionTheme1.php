<?php

namespace Components\Promotions;

use Components\Component;

/**
 * Theme 1 Promotion component
 */
class PromotionTheme1 extends Component
{
    public $body;
    public function __construct()
    {
        $this->body = <<<HTML
            <section class="promotion" id="theme-1">
                <div class="promotion-details dynamic-content">
                    <div class="content">
                        <div class="info">
                            <h4>WH-1000XM3</h4>
                            <h3>Sony Gürültü Önleyici Kulaklık</h3>
                        </div>
                        <div class="btns">
                            <a class="primary" href="http://localhost/product/sony-noise-canceling-headphones">Hemen Al</a>
                            <a class="secondary" href="http://localhost/products/elektronik/kulaklik">Hepsini Gör</a>
                        </div>
                    </div>
                    <div class="thumbnail">
                        <img src="http://localhost/global/imgs/promotions/showcase-product.png" alt="showcased product">
                    </div>
                </div>
            </section>
        HTML;
    }
}
