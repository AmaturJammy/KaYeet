<?php
require_once 'config.php';
$message = "";
if(isset($_GET['QuizID'])){
    $_REQUEST['QuizID'] = $_GET['QuizID'];
}
if(!isset($_REQUEST['currentQuestion'])){
    $_REQUEST['currentQuestion'] = 0;
}
if(isset($_POST['answerSubmit1'])){
    $_REQUEST['currentQuestion']++;
    print_r($_POST);
    header("Location: ". $_SERVER['REQUEST_URI']);
} else if(isset($_POST['answerSubmit2'])){
    $_REQUEST['currentQuestion']++;
    unset($_POST);
} else if(isset($_POST['answerSubmit3'])){
    $_REQUEST['currentQuestion']++;
    unset($_POST);
} else if(isset($_POST['answerSubmit4'])){
    $_REQUEST['currentQuestion']++;
    unset($_POST);
}
if(isset($_POST['resetCurrentQuestion'])){
    $_REQUEST['currentQuestion'] = 1;
}
$quiz = new Quiz();
$user = new User();
$logged_in = $user->checkLogin();
if(!isset($_REQUEST['currentQuestion'])){
    $_REQUEST['currentQuestion'] = 1;
}
$quiz_id = $_GET['QuizID'];
?>
<html>
<head>
	<title><?php echo "KaYeet | Playing Quiz ".$quiz_id. `.<br />`; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/Kayeet/Resources/stylesheets/stylesheet.css">
    <script type="text/javascript" src="Resources/javascript/script.js"></script>
</head>
<body>
    <script>playmusic();</script>
    <div id="titleTextDiv">
        <h1 onclick="location.href='control.php'" id="pageTitle">
            KaYeet
        </h1>
    </div>
    <div id="contentsDiv">
        <?php $quiz->ShowQuestion($_REQUEST['QuizID']);?>
    </div>
</body>
</html>