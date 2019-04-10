<?php
require_once 'config.php';
$message = "";

$user = new User();
$quiz = new Quiz();
$logged_in = $user->checkLogin();

if(!$logged_in){
    header("Location: homePage.php");
    exit;
}
?>
<html>
<head>
	<title>KaYeet | My KaYeets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="/Kayeet/Resources/stylesheets/stylesheet.css">
</head>
<body>
    <div id="titleTextDiv">
        <h1 id="pageTitle">
            KaYeet
        </h1>
    </div>
    <div id="contentsDiv">
        <button class="btn-hover color-1" onclick="location.href='createQuiz.php'">Create quiz</button><br>
        <button class="btn-hover color-1" onclick="location.href='logout.php'">Logout</button><br>
        <?php $quiz->showQuizes(); ?>
    </div>
</body>
</html>