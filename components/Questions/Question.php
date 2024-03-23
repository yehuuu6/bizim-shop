<?php

namespace Components\Questions;

use Components\Component;
use DateTime;

// Question component for product page

class Question extends Component
{
    public string $body;

    public function __construct(string $qid, string $question, string $answer, string $date, array $user)
    {
        $question = htmlspecialchars($question);
        $question = nl2br($question);
        $avatar = $this->get_image_src($user['avatar']);
        $this->body = <<<HTML
            <div class="question" data-id="{$qid}">
                {$this->render_delete_button($user,$qid)}
                <div class="author">
                    <div class="avatar">
                        <img src="{$avatar}" alt="avatar" />
                    </div>
                    <div class="user-info">
                        <h3>{$user['username']}</h3>
                        <span>{$this->calculate_time($date)}</span>
                    </div>
                </div>
                <p>
                    {$question}
                </p>
                <div class="answer">
                    <h3>Cevap</h3>
                    <p>{$answer}</p>
                </div>
            </div>
        HTML;
    }

    private function render_delete_button(array $user, string $id)
    {
        $body = "";
        if (isset($_SESSION['id']) && $_SESSION['id'] == $user['id']) {
            $body = <<<HTML
                <div data-question-id="{$id}" class="delete-question" title="Soruyu sil">
                    <i class="fas fa-trash"></i>
                </div>
            HTML;
        }
        return $body;
    }

    private function calculate_time($date)
    {
        // Get current date
        $currentDate = new DateTime();

        // Calculate the difference between dates
        $dateDifference = $currentDate->diff(new DateTime($date));
        $daysDifference = $dateDifference->days;

        // Determine the appropriate message
        if ($daysDifference == 0) {
            $message = 'Bugün';
        } elseif ($daysDifference == 1) {
            $message = 'Dün';
        } elseif ($daysDifference < 7) {
            $message = $daysDifference . ' gün önce';
        } elseif ($daysDifference < 30) {
            $weeks = floor($daysDifference / 7);
            $message = $weeks . ' hafta önce';
        } elseif ($daysDifference < 365) {
            $months = floor($daysDifference / 30);
            $message = $months . ' ay önce';
        } else {
            $years = floor($daysDifference / 365);
            $message = $years . ' yıl önce';
        }

        return $message;
    }

    private function get_image_src($image)
    {
        if ($image == 'nopp.png') {
            return 'http://localhost/global/imgs/nopp.png';
        } else {
            return "http://localhost/images/users/{$image}";
        }
    }
}
