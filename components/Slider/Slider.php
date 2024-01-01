<?php

namespace Components\Slider;

use Components\Component;

/**
 * Content slider component
 */
class Slider extends Component
{
    protected $slides = [];
    public function __construct($slides)
    {
        $this->slides = $slides;
        $body = <<<HTML
            <div id="slider">
                <input type="radio" name="slider" id="slide1" checked />
                <input type="radio" name="slider" id="slide2" />
                <input type="radio" name="slider" id="slide3" />
                <div id="slides">
                    <div id="overflow">
                        <div class="inner">
                            {$this->render_slides($this->slides)}
                        </div>
                    </div>
                </div>
                <div id="bullets">
                    <label for="slide1"></label>
                    <label for="slide2"></label>
                    <label for="slide3"></label>
                </div>
            </div>
        HTML;

        // Render the component on the page
        $this->render($body);
    }

    private function render_slides($slides)
    {
        $html = '';
        foreach ($slides as $slide) {
            $html .= $slide->body;
        }
        return $html;
    }
}
