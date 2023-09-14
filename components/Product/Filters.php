<?php

namespace Components\Product;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Product Search Filters component
 */
class Filters extends Component
{
    public function __construct()
    {
        $body = <<<HTML
        <form id="filters" class="product-filters">
            <h3 class="filter-title">Sıralama</h3>
            <select name="p-sort" id="p-sort">
                <option value="id ASC">Eskiden Yeniye</option>
                <option value="id DESC">Yeniden Eskiye</option>
                <option value="popularite">Populerlik</option>
                <option value="price ASC">Fiyat Artan</option>
                <option value="price DESC">Fiyat Azalan</option>
            </select>
            <h3 class="filter-title">Kategoriler</h3>
            <select name="p-category" id="p-category">
                <option value="0">Hepsini Göster</option>
                <option value="1">Müzik Seti</option>
                <option value="2">Hoparlör</option>
                <option value="3">Plak Çalar</option>
                <option value="4">Müzik Çalar</option>
            </select>
            <h3 class="filter-title">Fiyat Aralığı</h3>
            <div class="price-range">
            ₺
            <input
                type="number"
                name="min-price"
                id="min-price"
                placeholder="Min"
            />
            -
            <input
                type="number"
                name="max-price"
                id="max-price"
                placeholder="Max"
            />
            </div>
            <h3 class="filter-title">Diğer</h3>
            <div class="category">
                <input type="checkbox" name="p-featured" id="p-featured" />
                <label for="p-featured">Öne Çıkarılanlar</label>
            </div>
            <div class="category">
                <input type="checkbox" name="p-shipment" id="p-shipment" />
                <label for="p-shipment">Ücretsiz Kargo</label>
            </div>
            <button type="submit" class="apply-filters">Uygula</button>
        </form>
        HTML;

        // Render the component on the page
        parent::render($body);
    }
}
