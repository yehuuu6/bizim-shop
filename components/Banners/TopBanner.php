<?php

namespace Components\Banners;

use Components\Component;

/**
 * Top Banner component
 */
class TopBanner extends Component
{
    public function __construct()
    {
        $body = <<<HTML
            <div class="top-banner">
                <a href="#">{$this->set_banner_text()}</a>
            </div>
        HTML;

        // Render the component on the page
        parent::render($body);
    }

    /**
     * Gets the banner text from database and sets content.
     * @return string
     */
    private function set_banner_text()
    {
        // TODO: Get banner text from database
        return "İlk siparişinize özel kargo ücreti YOK!";
    }
}
