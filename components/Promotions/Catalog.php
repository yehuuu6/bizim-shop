<?php

namespace Components\Promotions;

use Components\Component;

/**
 * Catalog component
 */
class Catalog extends Component
{
    protected $cardItems = [
        <<<HTML
            <div class="category-card">
                <div class="category-image dynamic-content">
                    <img src="http://localhost/global/imgs/categories/electronic.jpg" alt="category" loading="lazy">
                </div>
                <a href="/products/elektronik">Elektronik</a>
            </div>
        HTML,
        <<<HTML
            <div class="category-card">
                    <div class="category-image dynamic-content">
                        <img src="http://localhost/global/imgs/categories/instrument.jpg" alt="category" loading="lazy">
                    </div>
                    <a href="/products/enstruman">Enstrüman</a>
                </div>
        HTML,
        <<<HTML
            <div class="category-card">
                    <div class="category-image dynamic-content">
                        <img src="http://localhost/global/imgs/categories/sneakers.jpg" alt="category" loading="lazy">
                    </div>
                    <a href="/products/moda">Moda</a>
                </div>
        HTML,
        <<<HTML
            <div class="category-card">
                    <div class="category-image dynamic-content">
                        <img src="http://localhost/global/imgs/categories/pets.jpg" alt="category" loading="lazy">
                    </div>
                    <a href="/products/evcil-hayvan">Evcil Hayvan</a>
                </div>
        HTML,
    ];
    public function __construct()
    {
        $body = <<<HTML
            <section class="home-page-featured" id="categories">
                {$this->render_card_items()}
            </section>
        HTML;

        parent::render($body);
    }

    private function render_card_items()
    {
        // Shuffle the cardItems array
        shuffle($this->cardItems);

        // Get the first 2 items
        $specialCardItems = array_splice($this->cardItems, 0, 2);

        // Add class "card-wide" or "card-tall" to the first 2 items randomly
        $randomFirstItem = rand(0, 1);
        $randomSecondItem = ($randomFirstItem == 0) ? rand(0, 1) : 0; // Second item can be any random value if the first item is "card-tall"

        foreach ($specialCardItems as $key => $cardItem) {
            $classToAdd = ($key == 0) ? ($randomFirstItem == 0 ? "card-tall" : "card-wide") : ($randomSecondItem == 0 ? "card-tall" : "card-wide");

            $specialCardItems[$key] = str_replace("category-card", "category-card " . $classToAdd, $cardItem);
        }

        // Add the special card items to the beginning of the array
        array_splice($this->cardItems, 0, 0, $specialCardItems);

        // Render the card items
        $cardItems = "";
        foreach ($this->cardItems as $cardItem) {
            $cardItems .= $cardItem;
        }

        return $cardItems;
    }
}
