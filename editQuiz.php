<?php
require_once('config.php');
$quiz = new Quiz();
$user = new User();
$logged_in = $user->checkLogin();
if(!$logged_in){
    header("Location: homePage.php");
}
if(isset($_POST['addNewQuestion'])){
    $quiz->addQuestion();
}
if(isset($_GET['QuizID'])){
    $quizname = $quiz->getQuiz($_GET['QuizID'])['QuizName'];
}else{
    $quizname = $quiz->getQuiz(0)['QuizName'];
}
if(array_key_exists('QuizID', $_GET)){
    $quiz_id = $_GET['QuizID'];
    $title = "KaYeet | Edit Quiz $quiz_id";
}else{
    $title = "KaYeet | Edit new Quiz";
}
?>
<html>
<head>
    <title><?php echo $title; ?></title>
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
            <label for="quizname">Quiz name</label><br>
            <input type="text" name="quizname" placeholder="Quiz name" value="<?php echo($quizname); ?>"><br>
            <h2>Add a question</h2>
            <input type="text" name="questionText" placeholder="Question name"><br>
            <input type="text" name="answer1" placeholder="Answer 1" style="width:95%;"><input type="checkbox" name="answer1check"><br>
            <input type="text" name="answer2" placeholder="Answer 2" style="width:95%;"><input type="checkbox" name="answer2check"><br>
            <input type="text" name="answer3" placeholder="Answer 3" style="width:95%;"><input type="checkbox" name="answer3check"><br>
            <input type="text" name="answer4" placeholder="Answer 4" style="width:95%;"><input type="checkbox" name="answer4check"><br>
            <input type="submit" class="btn-hover color-1" name="addNewQuestion" value="Vraag toevoegen">
        </form>
        <?php
        $quiz->showEditQuestions();
        ?>
    </div>
</body>
</html>