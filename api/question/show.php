<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once("../../config/db.php");
include_once("../../model/question.php");

$db = new Database();
$connect = $db->connect();

$question = new Question($connect);

$question->id_question = isset($_GET["id"]) ? $_GET["id"] : die();
$question->show();

$question_item = array(
    'question_id' => $question->id_question,
    'title' => $question->title,
    'question_a' => $question->question_a,
    'question_b' => $question->question_b,
    'question_c' => $question->question_c,
    'question_d' => $question->question_a,
    'question_correct' => $question->question_correct
);

print_r(json_encode($question_item));