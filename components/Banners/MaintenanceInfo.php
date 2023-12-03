<?php

namespace Components\Banners;

use Components\Component;

/**
 * Maintenance Info Banner component
 */
class MaintenanceInfo extends Component
{
    public function __construct()
    {
        $body = <<<HTML
            <div class="placeholder">
                <a href="/control-center/dashboard#manage-site"><i class="fa-solid fa-screwdriver-wrench"></i> <span>Bakım Modu Aktif</span> — Mağazayı kullanıma açmak için kapatın >></a>
            </div>
            <div class="maintenance-info dynamic-content">
                <a href="/control-center/dashboard#manage-site">
                    <i class="fa-solid fa-screwdriver-wrench"></i> <span>Bakım Modu Aktif</span> — Mağazayı kullanıma açmak için kapatın >>
                </a>
            </div>
        HTML;

        // Render the component on the page
        parent::render($body);
    }
}
