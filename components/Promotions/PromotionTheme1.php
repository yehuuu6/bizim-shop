<?php

namespace Components\Promotions;

use Components\Component;

/**
 * Theme 1 Promotion component
 */
class PromotionTheme1 extends Component
{
    public function __construct()
    {
        $body = <<<HTML
            <section class="promotion" id="theme-1">
                <div class="promotion-details dynamic-content">
                    <div class="content">
                        <div class="info">
                            <h4>Müzik Çalar</h4>
                            <h3>Sony Walkman</h3>
                        </div>
                        <div class="btns">
                            <a class="primary" href="http://localhost/product/sony-walkman">Hemen Al</a>
                            <a class="secondary" href="http://localhost/products/elektronik/muzik-calar">Hepsini Gör</a>
                        </div>
                    </div>
                    <div class="thumbnail">
                        <img src="http://localhost/global/imgs/promotions/showcase-product.png" alt="showcased product">
                    </div>
                </div>
            </section>
        HTML;

        // Render the component on the page
        $this->render($body);
    }
}
