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
    public function __construct()
    {

        $body = <<<HTML
            <nav class="navbar">
            <div class="flex-item site-name">
                <img
                src="http://localhost/global/imgs/favicon.svg"
                class="logo"
                alt=""
                />
                <a href="http://localhost">Bizim <span>Shop</span></a>
            </div>
            <div class="flex-item search-box">
                <input
                type="text"
                spellcheck="false"
                placeholder="Ürün, kategori veya marka ara"
                />
                <button class="search-btn" title="Ara">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="flex-item user-content">
                <div class="interactive">
                    <div class="n-cart">
                        <span id="navbar-cart-count"> 0 </span>
                        <a href="/cart" class="cart-btn" title="Sepetim">
                        <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                    <div class="n-wishlist" title="Beğendiklerim">
                        <span id="navbar-wishlist-count"> 0 </span>
                        <a href="wishlist" class="wishlist-btn">
                        <i class="fas fa-heart"></i>
                        </a>
                </div>
                </div>
                <hr />
                {$this->render_account_elements()}
            </div>
            </nav>
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

    /**
     * Renders account elements based on authentication status.
     * @return Html
     */
    private function render_account_elements()
    {
        if (!isset($_SESSION['id'])) {
            $body = <<<HTML
                <div class="account">
                    <div class="user-img">
                        <img src="http://localhost/global/imgs/nopp.png" alt="Profil resmi" />
                    </div>
                    <div class="a-content">
                        <span>Hesabım</span>
                        <span
                        ><a href="/auth/login">Giriş Yap</a> |
                        <a href="/auth/register">Kayıt Ol</a></span
                        >
                    </div>
                </div>
            HTML;
        } else {
            $src = PRODUCT_USER_SITE_PATH . $_SESSION['profile_image'] . "?timestamp=" . time();
            $body = <<<HTML
                <div class="account">
                    <div class="user-img">
                        <img src="{$src}" alt="Profil resmi" />
                    </div>
                    <div class="a-content">
                        <span>Hoş geldin {$_SESSION['name']}</span>
                        <span
                        ><a href="/account">Hesabım</a> |
                        <a href="/dashboard">Panel</a></span
                        >
                    </div>
                </div>
            HTML;
        }

        return $body;
    }
}
