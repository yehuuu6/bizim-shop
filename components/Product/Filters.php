<?php

namespace Components\Product;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Product Search Filters component
 */
class Filters extends Component
{
    protected string $category;

    public function __construct(string $category)
    {
        $this->category = $category;

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
                {$this->render_categories($category)}
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

    function render_categories(?string $category)
    {
        // Category provisions
        $categories = [
            '' => 'Hepsini Göster',
            'stereo' => 'Müzik Seti',
            'speakers' => 'Hoparlör',
            'turntables' => 'Plak Çalar',
            'music-players' => 'Müzik Çalar',
            'tapes-records' => 'Kaset & Plak'
        ];

        // Render the categories

        $html = '';

        for ($i = 0; $i < count($categories); $i++) {
            $key = array_keys($categories)[$i];
            $value = array_values($categories)[$i];
            $is_selected = $this->render_selected($category, $key);
            $html .= <<<HTML
            <option value="{$i}" {$is_selected}> {$value} </option>
            HTML;
        }

        return $html;
    }

    function render_selected(?string $category, string $key)
    {
        if ($category == $key) {
            return 'selected';
        }
    }
}
