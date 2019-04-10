<?php
require_once('config.php');
$quiz = new Quiz();
$user = new User();
$logged_in = $user->checkLogin();
if(isset($_POST['submitcreate'])){
    $quiz->createQuiz($_POST);
    header("Location: editQuiz.php");
    exit;
}

if(!$logged_in){
    header("Location: homePage.php");
    exit;
}
?>
<html>
<head>
    <title>KaYeet | Create new quiz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/Kayeet/Resources/stylesheets/stylesheet.css">
    <script type="text/javascript" src="Resources/javascript/script.js"></script>
</head>
<body>
    <div id="titleTextDiv">
        <h1 onclick="location.href='control.php'" id="pageTitle">
            KaYeet
        </h1>
    </div>
    <div id="contentsDiv">
        <form method="post">
            <input type="text" name="Quizname" placeholder="Quiz name">
            <label alt='Quizname' placeholder='Quizname'></label><br>
            <input type="text" name="questionText" placeholder="Question"><br>
            <input type="text" name="answer1" placeholder="Answer 1"><br>
            <input type="text" name="answer2" placeholder="Answer 2"><br>
            <input type="text" name="answer3" placeholder="Answer 3"><br>
            <input type="text" name="answer4" placeholder="Answer 4"><br>
            <input type="submit" class="btn-hover color-1" name="submitcreate" value="Add quiz">
        </form>
    </div>
</body>
</html>