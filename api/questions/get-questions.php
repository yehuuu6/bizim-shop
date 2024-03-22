<?php
define('FILE_ACCESS', TRUE);

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once("{$_SERVER['DOCUMENT_ROOT']}/includes/auth.inc.php");

use Components\Questions\Question;

if (!validate_request()) {
    send_forbidden_response();
}

$product_id = get_safe_value($con, $_POST['id']);
$offset = get_safe_value($con, $_POST['offset']);

$sql = "SELECT id, question, date, uid FROM questions WHERE pid = ? ORDER BY id DESC LIMIT 3 OFFSET ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('ii', $product_id, $offset);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];

while ($questions_data = $result->fetch_assoc()) {
    $user_id = $questions_data['uid'];

    $sql = "SELECT name, surname, profile_image FROM users WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $resultUser = $stmt->get_result();
    $user_data = $resultUser->fetch_assoc();

    $user = [
        'id' => $user_id,
        'username' => $user_data['name'] . ' ' . $user_data['surname'],
        'avatar' => $user_data['profile_image']
    ];

    $question = new Question($questions_data['id'], $questions_data['question'], 'Henüz bir cevap verilmedi.', $questions_data['date'], $user);
    array_push($questions, $question->body);
}

echo json_encode($questions);
