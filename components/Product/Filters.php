<?php

namespace Components\Product;

use Components\Component;

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/consts.inc.php';

/**
 * Product Search Filters component
 */
class Filters extends Component
{
    protected ?string $category_slug;
    protected ?string $category_id;
    protected ?string $sub_category_slug;

    public function __construct(?string $category_slug = "0", ?string $category_id = '0', ?string $sub_category_slug = '0')
    {
        $this->category_slug = $category_slug;
        $this->category_id = $category_id;
        $this->sub_category_slug = $sub_category_slug;

        $body = <<<HTML
        <form id="filters" class="product-filters">
            <input type="hidden" name="category" value="{$category_id}" />
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
                {$this->render_sub_categories($category_slug)}
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

    function render_sub_categories(?string $category_slug)
    {
        $sub_categories = get_sub_categories($category_slug);

        // Render the categories

        $html = <<<HTML
        <option value="0">Tümünü Göster</option>
        HTML;

        foreach ($sub_categories as $sub_cat) {
            $html .= <<<HTML
            <option value="{$sub_cat['id']}" data-slug="{$sub_cat['slug']}" {$this->render_selected($sub_cat['slug'],$this->sub_category_slug)}>{$sub_cat['name']}</option>
            HTML;
        }

        return $html;
    }

    function render_selected(?string $current_slug, ?string $selected_slug)
    {
        if ($current_slug == $selected_slug) {
            return "selected";
        }
    }
}
