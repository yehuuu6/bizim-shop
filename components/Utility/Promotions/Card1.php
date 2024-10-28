<?php

namespace Components\Utility\Promotions;

use Components\Component;

/**
 * Theme 1 Promotion component
 */
class Card1 extends Component
{
    public $body;
    public function __construct($con)
    {
        $promotion_data = $this->get_promotion($con);
        $vector = $this->render_vector($promotion_data);
        $this->body = <<<HTML
            <section class="promotion" id="theme-1">
                <div class="promotion-details dynamic-content" {$vector}>
                    <div class="content">
                        <div class="info">
                            <h4>{$this->get_promotion_title($promotion_data)}</h4>
                            <h3>{$this->get_promotion_description($promotion_data)}</h3>
                        </div>
                        <div class="btns">
                            <a class="primary" href="{$this->get_main_link($promotion_data)}">Hemen Al</a>
                            <a class="secondary" href="{$this->get_sub_link($promotion_data)}">Hepsini Gör</a>
                        </div>
                    </div>
                    <div class="thumbnail">
                        <img src="{$this->get_image($promotion_data)}" alt="showcased product">
                    </div>
                </div>
            </section>
        HTML;
    }

    private function get_promotion($con)
    {
        $query = "SELECT * FROM promotions WHERE id = ?";
        $stmt = $con->prepare($query);

        $id = 1; // Declare the variable for the promotion ID
        $stmt->bind_param('i', $id); // Pass the variable by reference

        $title = '';
        $description = '';
        $image = '';
        $vector = '';
        $main_link = '';
        $sub_link = '';

        // Execute the statement
        if ($stmt->execute()) {
            $stmt->bind_result($id, $title, $description, $image, $vector, $main_link, $sub_link);
            $stmt->fetch();
            $stmt->close();

            $result['id'] = $id;
            $result['title'] = $title;
            $result['description'] = $description;
            $result['image'] = $image;
            $result['vector'] = $vector;
            $result['mainTarget'] = $main_link;
            $result['secondTarget'] = $sub_link;

            return $result;
        } else {
            die("Bir hata oluştu.");
        }
    }

    private function render_vector($promotion)
    {
        if ($promotion['vector'] == "1") {
            return 'style="flex-direction: row-reverse;"';
        } else {
            return '';
        }
    }

    private function get_promotion_title($promotion)
    {
        return $promotion['title'];
    }
    private function get_promotion_description($promotion)
    {
        return $promotion['description'];
    }
    private function get_main_link($promotion)
    {
        return $promotion['mainTarget'];
    }
    private function get_sub_link($promotion)
    {
        return $promotion['secondTarget'];
    }
    private function get_image($promotion)
    {
        return "http://bizimshop.test/global/imgs/promotions/{$promotion['image']}";
    }
}
