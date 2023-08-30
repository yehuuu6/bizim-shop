<?php

namespace Components\Navbar;

if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}

require_once("{$_SERVER['DOCUMENT_ROOT']}/config/authenticator.php");
require_once("{$_SERVER['DOCUMENT_ROOT']}/config/constants.php");

if (isset($_SESSION['id']) && $_SESSION['verified'] == 0) {
    header("location: /auth/verify");
    die();
}

use Components\Component;

/**
 * Navbar component
 */
class Navbar extends Component
{
    public function __construct(array $props = [])
    {
        // Check if metadata props are valid
        $this->checkMetadata($props);

        // Set metadata props
        $metadata = $this->setMetadata($props);
        list($PAGE_TITLE, $PAGE_DESCRIPTION, $PAGE_KEYWORDS, $PAGE_AUTHOR, $PAGE_FAVICON) = $metadata;

        $body = <<<HTML
        <!DOCTYPE html>
            <html lang="tr">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="description" content="{$PAGE_DESCRIPTION}">
                <meta name="keywords" content="{$PAGE_KEYWORDS}">
                <meta name="author" content="{$PAGE_AUTHOR}">
                <link rel="stylesheet" href="/assets/css/main.css">
                <link rel="stylesheet" href="/assets/css/utils.css">
                <link rel="shortcut icon" href="{$PAGE_FAVICON}" type="image/x-icon">
                <script src="/global/plugins/icons.js"></script>
                <script src="/global/plugins/jquery.js"></script>
                <title>$PAGE_TITLE</title>
            </head>
            <body>
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
                    {$this->renderAuthElements()}
                    <li>
                        <button class="interactive" id="cart-btn">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </button>
                        <button class="interactive" id="wishlist-btn">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </li>
                </ul>
            </div>
            </nav>
        HTML;

        // Render the component on the page
        parent::render($body);
    }

    /**
     * Checks if metadata props are valid.
     * @throws Exception If one or more metadata props are invalid & has more than 5 props.
     */
    private function checkMetadata(array $props = [])
    {
        $allowed = [
            "title",
            "description",
            "keywords",
            "author",
            "favicon"
        ];

        if (count($props) > 5) {
            throw new \Exception("Navbar component has too many props.");
        }

        if ($props) {
            foreach (array_keys($props) as $key) {
                if (!in_array($key, $allowed)) {
                    throw new \Exception("Navbar component has an unknown prop.");
                }
            }
        }
    }

    /**
     * Sets page metadata based on props given to the component.
     */
    private function setMetadata(array $props = [])
    {
        $PAGE_TITLE = $props["title"] ?? DEFAULT_PAGE_TITLE;
        $PAGE_DESCRIPTION = $props["description"] ?? DEFAULT_PAGE_DESCRIPTION;
        $PAGE_KEYWORDS = $props["keywords"] ?? DEFAULT_PAGE_KEYWORDS;
        $PAGE_AUTHOR = $props["author"] ?? DEFAULT_PAGE_AUTHOR;
        $PAGE_FAVICON = $props["favicon"] ?? DEFAULT_PAGE_FAVICON;

        return [$PAGE_TITLE, $PAGE_DESCRIPTION, $PAGE_KEYWORDS, $PAGE_AUTHOR, $PAGE_FAVICON];
    }

    /**
     * Renders authentication buttons based on permissions.
     * @return Html
     */
    private function renderAuthElements()
    {
        if (!isset($_SESSION['id'])) {
            $body = <<<HTML
                <li><a class="no-decoration navbar-btn" href="/auth/login">Giriş Yap</a></li>
                <li><a class="no-decoration navbar-btn" href="/auth/register">Kayıt Ol</a></li>
            HTML;
        } else {
            $body = <<<HTML
                <li><a class="no-decoration navbar-btn" href="/dashboard">Hoşgeldin {$_SESSION['name']}</a></li>
                <li><a class="no-decoration navbar-btn" href="/?logout=1">Çıkış</a></li>
            HTML;
        }

        return $body;
    }
}
