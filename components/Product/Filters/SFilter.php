<?php

namespace Components\Product\Filters;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Product filter component for search page
 */
class SFilter extends Component
{
    protected string $query = "";
    public function __construct(string $query)
    {
        $this->query = $query;
        $body = <<<HTML
        <form id="filters" class="product-filters">
            <input type="hidden" name="search" value="{$this->query}" />
            <h3 class="filter-title">Sıralama</h3>
            <select name="p-sort" id="p-sort">
                <option value="id ASC">Eskiden Yeniye</option>
                <option value="id DESC">Yeniden Eskiye</option>
                <option value="popularite">Populerlik</option>
                <option value="price ASC">Fiyat Artan</option>
                <option value="price DESC">Fiyat Azalan</option>
            </select>
            <h3 class="filter-title">Kategoriler</h3>
            <select name="p-sub-category" id="p-sub-category">
                {$this->render_sub_categories()}
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

    function render_sub_categories()
    {
        $sub_categories = get_all_sub_categories();

        // Render the categories

        $html = <<<HTML
        <option value="0">Tümünü Göster</option>
        HTML;

        foreach ($sub_categories as $sub_cat) {
            $html .= <<<HTML
            <option value="{$sub_cat['id']}" data-slug="{$sub_cat['slug']}">{$sub_cat['name']}</option>
            HTML;
        }

        return $html;
    }
}
