<?php
define('FILE_ACCESS', TRUE);

require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

if (!validate_request()) {
    send_forbidden_response();
}

if (!isset($_SESSION['id'])) {
    send_forbidden_response();
}

$product_id = get_safe_value($con, $_POST['id']);
$question = get_safe_value($con, $_POST['question']);
$user_id = $_SESSION['id'];

if (!isset($product_id)) {
    send_error_response('Product ID is required');
}

if (!isset($question)) {
    send_error_response('Question is required');
}

if (strlen($question) < 10) {
    send_error_response('Question must be at least 10 characters long');
}

if (strlen($question) > 550) {
    send_error_response('Question must be at most 550 characters long');
}

$sql = "SELECT submissions, last_submission FROM users WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$submissions = $row['submissions'];
$last_sub = $row['last_submission'];

$submissions = reset_submission_counts($con, $submissions, $last_sub, $user_id);

$query = "INSERT INTO questions (pid, uid, question) VALUES (?, ?, ?)";

if ($submissions < 8) {
    try {
        $stmt = $con->prepare($query);
        $stmt->bind_param('iis', $product_id, $user_id, $question);
        $stmt->execute();
        $stmt->close();
        $submissions++;
        $sql = "UPDATE users SET submissions = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ii', $submissions, $user_id);
        $stmt->execute();
        $stmt->close();
        send_success_response('Soru başarıyla gönderildi.');
    } catch (Exception $e) {
        send_error_response($e->getMessage());
    }
} else {
    send_error_response('Çok fazla istek gönderdiniz. Lütfen 5 dakika sonra tekrar deneyin.');
}
