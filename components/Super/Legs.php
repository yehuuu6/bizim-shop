<?php

namespace Components\Super;

use Components\Component;

/**
 * Bottom of the page component
 */
class Legs extends Component
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
