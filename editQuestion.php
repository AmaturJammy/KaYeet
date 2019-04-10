<?php
require_once('config.php');
$quiz = new Quiz();
$user = new User();
$logged_in = $user->checkLogin();
$question_id = $_GET['QuestionID'];
if(!$logged_in){
    header("Location: homePage.php");
}
if(isset($_GET['QuestionID'])){
    $questionData = $quiz->getQuestion($_GET['QuestionID']);
    $answerData = $quiz->getAnswers($_GET['QuestionID']);
}else{
    $questionData = $quiz->getQuestion(0);
    $answerData = $this->getAnswers($_GET['QuestionID']);
}
if(isset($_POST['editQuestion'])){
    if(isset($answerData[0]['AnswerText'])){
        $_REQUEST['answer1ID'] = $answerData[0]['AnswerID'];
    }
    if(isset($answerData[1]['AnswerText'])){
        $_REQUEST['answer2ID'] = $answerData[1]['AnswerID'];
    }
    if(isset($answerData[2]['AnswerText'])){
        $_REQUEST['answer3ID'] = $answerData[2]['AnswerID'];
    }
    if(isset($answerData[3]['AnswerText'])){
        $_REQUEST['answer4ID'] = $answerData[3]['AnswerID'];
    }
    
    $quiz->EditQuestion($_GET['QuestionID']);
    header("Location: editQuiz.php");
    exit;
}
?>
<html>
<head>
	<title><?php echo "KaYeet | Edit Question ".$question_id. `.<br />`; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="/Kayeet/Resources/stylesheets/stylesheet.css">
</head>
<body>
    <div id="titleTextDiv">
        <h1 onclick="location.href='control.php'" id="pageTitle">
            KaYeet
        </h1>
    </div>
    <div id="contentsDiv">
        <form method="post">
            <input type="text" name="questionText" placeholder="Question name" value="<?php echo($questionData['QuestionText']); ?>"><br>
            <input type="text" name="answer1" style="width:95%;" placeholder="Antwoord 1" value='<?php if(isset($answerData[0]['AnswerText'])){ echo($answerData[0]['AnswerText']); } ?>'><input type="checkbox" name="answer1check" <?php if(isset($answerData[0]['Correct']) && $answerData[0]['Correct'] != 0){ echo('checked'); }?>><br>
            <input type="text" name="answer2" style="width:95%;" placeholder="Antwoord 2" value='<?php if(isset($answerData[1]['AnswerText'])){ echo($answerData[1]['AnswerText']); $_REQUEST['answer2ID'] = $answerData[1]['AnswerID']; } ?>'><input type="checkbox" name="answer2check" <?php if(isset($answerData[1]['Correct']) && $answerData[1]['Correct'] != 0){ echo('checked'); }?>><br>
            <input type="text" name="answer3" style="width:95%;" placeholder="Antwoord 3" value='<?php if(isset($answerData[2]['AnswerText'])){ echo($answerData[2]['AnswerText']); $_REQUEST['answer3ID'] = $answerData[2]['AnswerID']; } ?>'><input type="checkbox" name="answer3check" <?php if(isset($answerData[2]['Correct']) && $answerData[2]['Correct'] != 0){ echo('checked'); }?>><br>
            <input type="text" name="answer4" style="width:95%;" placeholder="Antwoord 4" value='<?php if(isset($answerData[3]['AnswerText'])){ echo($answerData[3]['AnswerText']); $_REQUEST['answer4ID'] = $answerData[3]['AnswerID']; } ?>'><input type="checkbox" name="answer4check" <?php if(isset($answerData[3]['Correct']) && $answerData[3]['Correct'] != 0){ echo('checked'); }?>><br>
            <input type="submit" class="btn-hover color-1" name="editQuestion" value="Vraag aanpassen">
        </form>
    </div>
</body>
</html>