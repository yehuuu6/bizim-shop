<?php

namespace Components\Navbar;

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

use Components\Component;

/**
 * Navbar component
 */
class Navbar extends Component
{
    public function __construct(array $props = [])
    {

        $body = <<<HTML
            <nav class="navbar flex-display justify-between align-center">
                <div class="navbar-item flex-display gap-5 align-center">
                    <img class="navbar-svg large-svg no-drag" src="/global/imgs/favicon.svg" alt="">
                    <h2 class="navbar-logo flex-display gap-5">Bizim <div class="blue-text bold-text">Shop</div>
                    </h2>
                </div>
                <div class="navbar-item">
                    <ul class="no-list-style flex-display justify-space-around align-center">
                        <img class="navbar-svg medium-svg" src="/global/imgs/linksvg.svg" alt="">
                        <li><a class="no-decoration navbar-btn" href="/">Ana Sayfa</a></li>
                        <li><a class="no-decoration navbar-btn" href="/products">Ürünler</a></li>
                        <li><a class="no-decoration navbar-btn" href="/feedbacks">Yorumlar</a></li>
                    </ul>
                </div>
                <div class="navbar-item">
                <ul class="no-list-style flex-display justify-space-around align-center">
                    <img class="navbar-svg small-svg" src="/global/imgs/usersvg.svg" alt="">
                    {$this->render_auth_elements()}
                    <li>
                        <div class="interactive-btns">
                            <a href="/cart" class="interactive" id="cart-btn">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span id="navbar-cart-count" class="item-count">0</span>
                            </a>
                            <a href="/wishlist" class="interactive" id="wishlist-btn">
                                <i class="fa-solid fa-heart"></i>
                                <span id="navbar-wishlist-count" class="item-count">0</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            </nav>
        HTML;

        // Render the component on the page
        parent::render($body);
    }

    /**
     * Renders authentication buttons based on permissions.
     * @return Html
     */
    private function render_auth_elements()
    {
        if (!isset($_SESSION['id'])) {
            $body = <<<HTML
                <li><a class="no-decoration navbar-btn" href="/auth/login">Giriş Yap</a></li>
                <li><a class="no-decoration navbar-btn" href="/auth/register">Kayıt Ol</a></li>
            HTML;
        } else {
            $body = <<<HTML
                <li><a class="no-decoration navbar-btn" href="/edit-profile">Profili Düzenle</a></li>
                <li><a class="no-decoration navbar-btn" href="/dashboard">Panel</a></li>
                <li><a class="no-decoration navbar-btn" href="/?logout=1">Çıkış</a></li>
            HTML;
        }

        return $body;
    }
}
