<?php

namespace Components\Categories;

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
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

        $body = <<<HTML
            <div class="categories-container">
                <ul class="categories">
                    <li class="category">
                        <a href="/products/stereo">Müzik Seti</a>
                    </li>
                    <li class="category">
                        <a href="/products/speakers">Hoparlör</a>
                    </li>
                    <li class="category">
                        <a href="/products/turntables">Plak Çalar</a>
                    </li>
                    <li class="category">
                        <a href="/products/music-players">Müzik Çalar</a>
                    </li>
                    <li class="category">
                        <a href="/products/tapes-records">Kaset & Plak</a>
                    </li>
                    <li class="category">
                        <a href="/products">Tüm Kategoriler</a>
                    </li>
                </ul>
            </div>
        HTML;

        // Render the component on the page
        parent::render($body);
    }
}
