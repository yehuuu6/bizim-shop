<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

authorize_user();

$status = get_safe_value($con, $_POST['status']);

$last_update_date = date('Y-m-d H:i:s');

$result = [set_status_icon($status), set_status_text($status)];

function set_status_icon($status)
{
    switch ($status) {
        case '0':
            return '<i class="fas fa-clock status-icon waiting"></i>';
        case '1':
            return '<i class="fas fa-box status-icon processing"></i>';
        case '2':
            return '<i class="fas fa-truck status-icon shipping"></i>';
        case '3':
            return '<i class="fas fa-truck-fast status-icon shipping"></i>';
        case '4':
            return '<i class="fas fa-check-circle status-icon delivered"></i>';
        case '5':
            return '<i class="fas fa-ban status-icon canceled"></i>';
        case '6':
            return '<i class="fas fa-undo status-icon refunded"></i>';
        default:
            return '<i class="fas fa-question-circle status-icon unknown"></i>';
    }
}

function render_body($text)
{
    global $last_update_date;
    $date = get_date($last_update_date);
    return <<<HTML
        <div class="ship-stat">
            <strong>{$text}</strong>
            <span>{$date}</span>
        </div>
    HTML;
}

function set_status_text($status)
{
    switch ($status) {
        case '0':
            return render_body('Beklemede');
        case '1':
            return render_body('Hazırlanıyor');
        case '2':
            return render_body('Kargoya Verildi');
        case '3':
            return render_body('Dağıtımda');
        case '4':
            return render_body('Teslim Edildi');
        case '5':
            return render_body('İptal Edildi');
        case '6':
            return render_body('İade Edildi');
        default:
            return render_body('Bilinmeyen Durum');
    }
}

echo json_encode($result);
