<?php

namespace Components\Navbar;

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.php');
    exit;
}

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

use Components\Component;

/**
 * Navbar component
 */
class Navbar extends Component
{
    private string $query = "";

    public function __construct()
    {
        global $con;
        $this->query = isset($_GET['q']) ? get_safe_value($con, $_GET['q']) : "";
        $body = <<<HTML
            <nav class="navbar">
                <div class="flex-item site-name">
                    <img
                    src="http://localhost/global/imgs/logo.png"
                    class="logo"
                    alt=""
                    />
                    <a href="http://localhost">Bizim <span>Shop</span></a>
                </div>
                <div class="flex-item search-box">
                    <input
                    type="text"
                    spellcheck="false"
                    placeholder="Ürün aramaya başla..."
                    id="search-products"
                    value="{$this->query}"
                    />
                    <button class="search-btn" title="Ara">
                        <i class="fas fa-search"></i>
                    </button>
                    <div class="search-results">
                    </div>
                </div>
                <div class="flex-item user-content dynamic-content">
                    <div class="interactive">
                        <div class="n-cart">
                            <span id="navbar-cart-count"> 0 </span>
                            <a href="/cart" class="cart-btn" title="Sepetim">
                            <i class="fas fa-shopping-cart"></i>
                            </a>
                        </div>
                        <div class="n-wishlist" title="Beğendiklerim">
                            <span id="navbar-wishlist-count"> 0 </span>
                            <a href="/wishlist" class="wishlist-btn">
                            <i class="fas fa-heart"></i>
                            </a>
                    </div>
                    </div>
                    <hr />
                    {$this->render_account_elements()}
                </div>
            </nav>
        HTML;

        // Render the component on the page
        parent::render($body);
    }
    /**
     * Returns the image source for the user profile image.
     * @return string
     */
    private function get_img_src()
    {
        if ($_SESSION['profile_image'] === 'nopp.png') {
            return "http://localhost/global/imgs/nopp.png";
        } else {
            return PRODUCT_USER_SITE_PATH . $_SESSION['profile_image'] . "?timestamp=" . time();
        }
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
            $src = $this->get_img_src();
            $body = <<<HTML
                <div class="account">
                    <div class="user-img">
                        <img src="{$src}" alt="Profil resmi" onerror="this.src='http://localhost/global/imgs/nopp.png'"/>
                    </div>
                    <div class="a-content">
                        <span>Hoş geldin, {$_SESSION['name']}</span>
                        <span
                        ><a href="/control-center/account">Hesabım</a> |
                        <a href="/control-center/dashboard">Panel</a></span
                        >
                    </div>
                </div>
            HTML;
        }

        return $body;
    }
}
