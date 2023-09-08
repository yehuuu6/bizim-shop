<?php

namespace Components\Loader;

use Components\Component;

/**
 * Loader component
 */
class Loader extends Component
{
    public function __construct()
    {
        $body = <<<HTML
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:transparent;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <circle id="loader-bg-circle" cx="50" cy="50" r="30" stroke="#a1a1a1" stroke-width="10" fill="none"></circle>
            <circle cx="50" cy="50" r="30" stroke="#5943ff" stroke-width="8" stroke-linecap="round" fill="none">
                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;180 50 50;720 50 50" keyTimes="0;0.5;1"></animateTransform>
                <animate attributeName="stroke-dasharray" repeatCount="indefinite" dur="1s" values="18.84955592153876 169.64600329384882;94.2477796076938 94.24777960769377;18.84955592153876 169.64600329384882" keyTimes="0;0.5;1"></animate>
            </circle>
          </svg>
        HTML;

        // Render the component on the page
        $this->render($body);
    }
}
