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
            <form id='ask-question'>
                <div class='group'>
                    <span class='character-counter'>0/1000</span>
                    <textarea placeholder='Ürün hakkında soru sor...' name='question' id='question' rows='5' required maxlength='1000'></textarea>
                </div>
                <button type='submit' class='submit-question-btn'>Soru sor</button>
            </form>

        HTML;

        // Render the component on the page
        parent::render($body);
    }
}
