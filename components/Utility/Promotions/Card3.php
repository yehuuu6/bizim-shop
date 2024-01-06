<?php

namespace Components\Utility\Promotions;

use Components\Component;

/**
 * Theme 3 Promotion component
 */
class Card3 extends Component
{
    public $body;
    public function __construct()
    {
        $this->body = <<<HTML
            <section class="promotion" id="theme-3">
                <div class="promotion-details dynamic-content">
                    <div class="thumbnail" style="border-radius: 99999px;">
                        <img src="http://localhost/global/imgs/promotions/buying.png" alt="showcased product">
                    </div>
                    <div class="content">
                        <div class="info">
                            <h4>Kullanmadığınız cihaz mı var?</h4>
                            <h3>Onları Bize Satın!</h3>
                        </div>
                        <div class="btns">
                            <a class="primary" href="#">Teklif Ver</a>
                            <a class="secondary" href="#">Detaylar</a>
                        </div>
                    </div>
                </div>
            </section>
        HTML;
    }
}
