<?php

namespace Components\Product;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Order details component (For admin panel)
 */
class OrderDetails extends Component
{
    public $body;
    public function __construct(array $order, array $product)
    {
        $fee_cost = $product['price'] * KDV;
        $fee_cost = number_format($fee_cost, 2, '.', '');

        $total_price = (float)$product['price'] + (float)$fee_cost;

        // Convert the total price to a readable number.
        $price = readable_num($total_price);
        $date = get_date($order['last_update']);
        $this->body = <<<HTML
        <div class="order-details">
            <span class="close-order-tab" onclick="document.querySelector('.order-wrapper').remove();">
                <i class="fas fa-times"></i>
            </span>
            <div class="main-info">
                <div class="product-detail-wrapper">
                    <div class="product-details">
                        <div class="product-image">
                            <img src="{$product['image']}" alt="{$product['name']}">
                        </div>
                        <div class="product-info">
                            <h3>Teslimat No <strong>{$order['id']}</strong></h3>
                            <h3>{$product['name']}</h3>
                            <p>{$price} TL</p>
                        </div>
                    </div>
                    <div class="product-node">
                        <div id="node-1" class="order-tracker">
                            <span class="node"></span>
                            <p>Sipariş verildi</p>
                        </div>
                        <div id="node-2" class="order-tracker">
                            <span class="node"></span>
                            <p>Kargoya verildi</p>
                        </div>
                        <div id="node-3" class="order-tracker">
                            <span class="node"></span>
                            <p>Teslim edildi</p>
                        </div>
                    </div>
                </div>
                <div class="status">
                    <div class="shipment">
                        {$this->set_status_icon($order['status'])}
                        <div class="ship-stat">
                            <strong>{$this->set_status_text($order['status'])}</strong>
                            <span>{$date}</span>
                        </div>
                    </div>
                    <hr>
                    <h4>Sipariş Durumunu Güncelle</h4>
                    <div class="buttons" data-id="{$order['orderid']}">
                        <button data-val="0" title="Beklemede" class="dashboard-btn status-btn"><i class="fa-solid fa-clock"></i></button>
                        <button data-val="1" title="Hazırlanıyor" class="dashboard-btn status-btn"><i class="fa-solid fa-box"></i></button>
                        <button data-val="2" title="Kargoya Verildi" class="dashboard-btn edit-btn"><i class="fa-solid fa-truck"></i></button>
                        <button data-val="3" tiptle="Dağıtımda" class="dashboard-btn edit-btn"><i class="fa-solid fa-truck-fast"></i></button>
                        <button data-val="4" title="Teslim Edildi" class="dashboard-btn success-btn"><i class="fa-solid fa-check-circle"></i></button>
                        <button data-val="5" title="İptal Et" class="dashboard-btn delete-btn"><i class="fa-solid fa-ban"></i></button>
                        <button data-val="6" title="İade Et" class="dashboard-btn delete-btn"><i class="fa-solid fa-undo"></i></button>
                    </div>
                </div>
            </div>
        </div>
        HTML;
    }

    private function set_status_icon($status)
    {
        switch ($status) {
            case '0':
                return '<i class="fas fa-clock status-icon waiting"></i>';
            case '1':
                return '<i class="fas fa-box status-icon processing"></i>';
            case '2':
                return '<i class="fas fa-truck status-icon shipping"></i>';
            case '3':
                return '<i class="fas fa-truck-fast status-icon shipping"></i>';
            case '4':
                return '<i class="fas fa-check-circle status-icon delivered"></i>';
            case '5':
                return '<i class="fas fa-ban status-icon canceled"></i>';
            case '6':
                return '<i class="fas fa-undo status-icon refunded"></i>';
            default:
                return '<i class="fas fa-question-circle status-icon unknown"></i>';
        }
    }

    private function set_status_text($status)
    {
        switch ($status) {
            case '0':
                return 'Beklemede';
            case '1':
                return 'Hazırlanıyor';
            case '2':
                return 'Kargoya Verildi';
            case '3':
                return 'Dağıtımda';
            case '4':
                return 'Teslim Edildi';
            case '5':
                return 'İptal Edildi';
            case '6':
                return 'İade Edildi';
            default:
                return 'Bilinmeyen Durum';
        }
    }
}
