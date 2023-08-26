<?php
if (!defined('FILE_ACCESS')) {
    header("HTTP/1.1 403 Forbidden");
    include($_SERVER['DOCUMENT_ROOT'] . '/errors/403.html');
    exit;
}
function HelpCenterItem($props)
{
    return <<<HTML
    <section id={$props["id"]} class="page-content secondary-bg">
        <div class="content white-text">
            <h1 class="header-title">{$props["title"]}</h1>
            <p class="header-text text-bg text-bg-p-1">
                Yakında burada {$props["title"]} sayfası olacak.
            </p>
        </div>
    </section>
HTML;
}
