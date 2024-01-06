<?php

namespace Components\Layout\Meta;

use Components\Component;

/**
 * Bottom of the page which includes the scripts and closes the body and html tags
 */
class Bottom extends Component
{
    public function __construct()
    {
        $body = <<<HTML
            <script src="/dist/core/r9k2p4i7h0o1g5w6a2u3.js"></script>
            </body>
            </html>
        HTML;

        // Render the component on the page
        parent::render($body);
    }
}
