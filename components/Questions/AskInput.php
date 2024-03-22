<?php

namespace Components\Questions;

use Components\Component;

/**
 * Question input for product page component
 */
class AskInput extends Component
{
    public function __construct()
    {
        $body = <<<HTML
            <form class="ask-question">
                <h3>Satıcıya Soru Sor</h3>
                <div style="position: relative;">
                <span class="character-count">0/550</span>
                <textarea
                name="question"
                id="question"
                cols="30"
                rows="5"
                maxlength="550"
                placeholder="Sorunuzu buraya yazın..."
                required
                ></textarea>
                </div>
                <button>Gönder</button>
            </form>

        HTML;

        // Render the component on the page
        parent::render($body);
    }
}
