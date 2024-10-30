<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once("../../config/db.php");
include_once("../../model/question.php");

$db = new Database();
$connect = $db->connect();

$question = new Question($connect);

$read = $question->read();



$num = $read->rowCount();


if ($num > 0) {

    $question_array = [];
    $question_array['questions'] = [];

    while ($row = $read->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $question_item = array(
            'id_question' => $id_question,
            'title' => $title,
            'question_a' => $question_a,
            'question_b' => $question_b,
            'question_c' => $question_c,
            'question_d' => $question_d,
            'question_correct' => $question_correct
        );

        array_push($question_array['questions'], $question_item);
    }

    echo json_encode($question_array);
}
