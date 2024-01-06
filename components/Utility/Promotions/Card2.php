<?php

namespace Components\Utility\Promotions;

use Components\Component;

/**
 * Theme 2 Promotion component
 */
class Card2 extends Component
{
    public $body;
    public function __construct()
    {
        $this->body = <<<HTML
            <section class="promotion" id="theme-2">
                <div class="promotion-details dynamic-content">
                    <div class="content">
                        <div class="info">
                            <h4>Yardım mı lazım?</h4>
                            <h3>Bozuk Cihazınızı Tamir Edebiliriz!</h3>
                        </div>
                        <div class="btns">
                            <a class="primary" href="#">İletişime Geç</a>
                            <a class="secondary" href="#">Detaylar</a>
                        </div>
                    </div>
                    <div class="thumbnail" style="border-radius: 99999px;">
                        <img src="http://localhost/global/imgs/promotions/fixing.png" alt="showcased product">
                    </div>
                </div>
            </section>
        HTML;
    }
}
