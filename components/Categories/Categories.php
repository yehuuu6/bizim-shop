<?php

namespace Components\Categories;

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

use Components\Component;

/**
 * Categories container component
 */
class Categories extends Component
{
    public function __construct()
    {
        $body = $this->get_category_body();

        // Render the component on the page
        parent::render($body);
    }

    private function get_category_body()
    {
        $body = "";
        foreach (get_categories() as $category) {
            $link_name = convert_link_name($category['name']);
            $sub_categories = get_sub_categories($category['slug']);
            $body .= <<<HTML
                <li class="category">
                    <a href="/products/{$link_name}">{$category['name']}</a>
                    <ul class="sub-category-lister">
                        {$this->render_sub_categories($sub_categories,$category['slug'])}
                    </ul>
                </li>
            HTML;
        }
        return $body;
    }

    private function render_sub_categories($sub_categories, $category_slug)
    {
        $url_slug = urlencode(urlencode($category_slug));
        $body = "";
        // If length of sub_categories is 0, return "Kategori yok"
        if (count($sub_categories) === 0) {
            $body .= <<<HTML
                <li class="sub-category">
                    <a href="/products/{$category_slug}">Kategori yok</a>
                </li>
            HTML;
            return $body;
        }
        foreach ($sub_categories as $sub_category) {
            $url_sub_category_slug = urlencode(urlencode($sub_category['slug']));
            $body .= <<<HTML
                <li class="sub-category">
                    <a href="/products/{$url_slug}/{$url_sub_category_slug}">{$sub_category['name']}</a>
                </li>
            HTML;
        }
        return $body;
    }
}
