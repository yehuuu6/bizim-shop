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
            <select name="sort" id="sort">
                <option value="popularite">Populerlik</option>
                <option value="price-ascending">Fiyat Artan</option>
                <option value="price-descending">Fiyat Azalan</option>
                <option value="date-new">Yeniden Eskiye</option>
                <option value="date-old">Eskiden Yeniye</option>
            </select>
            <h3 class="filter-title">Kategoriler</h3>
            <div class="category">
                <input type="checkbox" name="p-music-set" id="p-music-set" />
                <label for="p-music-set">Müzik Seti</label>
            </div>
            <div class="category">
                <input type="checkbox" name="p-speaker" id="p-speaker" />
                <label for="p-speaker">Hoparlör</label>
            </div>
            <div class="category">
                <input type="checkbox" name="p-turntables" id="p-turntables" />
                <label for="p-turntables">Plak Çalar</label>
            </div>
            <div class="category">
                <input type="checkbox" name="p-music-player" id="p-music-player" />
                <label for="p-music-player">Müzik Çalar</label>
            </div>
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
        </form>
        HTML;

        // Render the component on the page
        parent::render($body);
    }
}
