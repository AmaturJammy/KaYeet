<?php
class Quiz{
    protected $db;
    protected $quizData;
    protected $questionData;
    public function __construct(){
        $this->db = DB::getInstance();
    }
    public function createQuiz(){
        if(isset($_REQUEST['Quizname'])){
            $user = new User();
            if($user->CheckLogin()){
                $sql = 'INSERT INTO quiz (UserID,QuizName) VALUES(:userID, :quizName)';
                $params = ['userID' => $user->getValue('UserID'), 'quizName' => $_REQUEST['Quizname']];
                $result = $this->db->run( $sql, $params );
                $this->addQuestion($_REQUEST);
                return $result;
            }
        }else{
            echo("Hij doet het niet");
        }
    }
    public function getQuiz($quizID){
        $useQuizID = $quizID;
        if($quizID == 0){
            $useQuizID = $this->getQuizID();
        }
        $quizData = $this->db->run("SELECT * FROM quiz WHERE QuizID = ? ORDER BY QuizID DESC LIMIT 1", [$useQuizID])->fetch();
        if(is_array($quizData)){
            return $quizData;
        }
    }
    public function getQuestion($questionID){
        if($questionID == 0){
            echo("Geen questionID");
        }else{
            $questionData = $this->db->run("SELECT * FROM question WHERE QuestionID = ? ORDER BY QuestionID DESC LIMIT 1", [$questionID])->fetch();
            if(is_array($questionData)){
                return $questionData;
            }
        }
    }
    public function getAnswers($questionID){
        if($questionID == 0){
            echo("Geen questionID");
        }else{
            $answerData = $this->db->run("SELECT * FROM answer WHERE QuestionID = ? ORDER BY AnswerID ASC", [$questionID])->fetchAll();
            return $answerData;
        }
    }
    public function getQuizID(){
        $user = new User();
        $quizIDQuery = null;
        if($user->CheckLogin()){
            $userID = $user->getValue('UserID');
        }
        $quizIDQuery = $this->db->run("SELECT * FROM quiz WHERE UserID = ? ORDER BY QuizID DESC LIMIT 1", [$userID])->fetch();
        if(is_array($quizIDQuery)){
            $quizIDQuery = $quizIDQuery['QuizID'];
        }else{
            $quizIDQuery = 0;
        }
        return $quizIDQuery;
    }
    public function addQuestion(){
        if(isset($_GET['QuizID'])){
            $quizID = $_GET['QuizID'];
        }else{
            $quizID = $this->getQuizID();
        }
        $questionIDQuery = $this->db->run("SELECT * FROM question ORDER BY QuestionID DESC LIMIT 1")->fetch();
        if(is_array($questionIDQuery)){
            $questionID = $questionIDQuery['QuestionID'];
            $questionID++;
        }else{
            echo("Error. Het is geen array boii");
            $questionID = 0;
        }
        if(isset($_REQUEST['questionText']) && isset($_REQUEST['answer1']) && isset($_REQUEST['answer2'])){
            if(!empty($_REQUEST['questionIMG'])){
                $questionIMG = $_REQUEST['questionIMG'];
            }else{
                $questionIMG = "";
            }
            //Question into database
            $sql = 'INSERT INTO question (QuizID, QuestionText, QuestionIMG) VALUES(:quizID, :questionText, :questionIMG)';
            $params = ['quizID' => $quizID, 'questionText' => $_REQUEST['questionText'], 'questionIMG' => $questionIMG];
            $result = $this->db->run( $sql, $params );
            if(!isset($_REQUEST['answer1check'])){
                $_REQUEST['answer1check'] = false;
            }else{
                $_REQUEST['answer1check'] = true;
            }
            if(!isset($_REQUEST['answer2check'])){
                $_REQUEST['answer2check'] = false;
            }else{
                $_REQUEST['answer2check'] = true;
            }
            if(!isset($_REQUEST['answer3check'])){
                $_REQUEST['answer3check'] = false;
            }else{
                $_REQUEST['answer3check'] = true;
            }
            if(!isset($_REQUEST['answer4check'])){
                $_REQUEST['answer4check'] = false;
            }else{
                $_REQUEST['answer4check'] = true;
            }
            //Answers into database
            if(!empty($_REQUEST['answer1'])){
                $this->addAnswer($questionID, $_REQUEST['answer1'], $_REQUEST['answer1check']);
            }
            if(!empty($_REQUEST['answer2'])){
                $this->addAnswer($questionID, $_REQUEST['answer2'], $_REQUEST['answer2check']);
            }
            if(!empty($_REQUEST['answer3'])){
                $this->addAnswer($questionID, $_REQUEST['answer3'], $_REQUEST['answer3check']);
            }
            if(!empty($_REQUEST['answer4'])){
                $this->addAnswer($questionID, $_REQUEST['answer4'], $_REQUEST['answer4check']);
            }
            return $result;
        }
    }
    public function addAnswer($questionID, $answerText, $isCorrect){
        $sql = 'INSERT INTO answer (QuestionID, AnswerText, Correct) VALUES(:questionID, :answerText, :correct)';
        $params = ['questionID' => $questionID, 'answerText' => $answerText, 'correct' => $isCorrect];
        $result = $this->db->run( $sql, $params );
        return $result;
    }
    public function showEditQuestions(){
        $questions = null;
        $answers = null;
        $quizID = 0;
        if(!isset($_GET['QuizID'])){
            $quizID = $this->getQuizID();
        }else{
            $quizID = $_GET['QuizID'];
        }
        if($quizID == 0){
            $quizID = $this->getQuizID();
        }
        $questions = $this->db->run("SELECT * FROM question WHERE QuizID = ? ORDER BY QuizID DESC", [$quizID])->fetchAll();
        foreach($questions as $question){
            echo("<a href='editQuestion.php?QuestionID=".$question['QuestionID']."'>");
            echo("QuestionName ". $question["QuestionText"]. "<br>");
            $answers = $this->db->run("SELECT * FROM answer WHERE QuestionID = ? ORDER BY QuestionID DESC", [$question["QuestionID"]])->fetchAll();
            foreach($answers as $answer){
                echo("Answer ". $answer['AnswerText']. " is ". $answer['Correct']. "<br>");
            }
            echo("</a><br><br>");
        }
    }
    public function editQuestion($questionID){
        if($questionID == 0){
            echo("Geen questionID");
        }else{
            $questionUpdate = $this->db->run("UPDATE question SET QuestionText = :questionText WHERE QuestionID = :questionID", ['questionText' => $_REQUEST['questionText'], 'questionID' => $questionID]);
            if(isset($_REQUEST['answer1ID'])){
                if(!isset($_REQUEST['answer1check'])){
                    $_REQUEST['answer1check'] = false;
                }else{
                    $_REQUEST['answer1check'] = true;
                }
                $answer1Update = $this->db->run("UPDATE answer SET AnswerText = :answerText, Correct = :answerCorrect WHERE AnswerID = :answerID", ['answerText' => $_REQUEST['answer1'], 'answerCorrect' => $_REQUEST['answer1check'], 'answerID' => $_REQUEST['answer1ID']]);
                if(!$answer1Update){
                    $answer1Update = $this->db->run("INSERT INTO answer (QuestionID, AnswerText, Correct) VALUES(':questionID', ':answerText', ':answerCorrect')", ['answerText' => $_REQUEST['answer1'], 'answerCorrect' => $_REQUEST['answer1check'], 'answerID' => $_REQUEST['answer1ID'], 'questionID' => $questionID]);
                }
            }
            if(isset($_REQUEST['answer2ID'])){
                if(!isset($_REQUEST['answer2check'])){
                    $_REQUEST['answer2check'] = false;
                }else{
                    $_REQUEST['answer2check'] = true;
                }
                $answer1Update = $this->db->run("UPDATE answer SET AnswerText = :answerText, Correct = :answerCorrect WHERE AnswerID = :answerID", ['answerText' => $_REQUEST['answer2'], 'answerCorrect' => $_REQUEST['answer2check'], 'answerID' => $_REQUEST['answer2ID']]);
                if(!$answer1Update){
                    $answer1Update = $this->db->run("INSERT INTO answer (QuestionID, AnswerText, Correct) VALUES(':questionID', ':answerText', ':answerCorrect')", ['answerText' => $_REQUEST['answer2'], 'answerCorrect' => $_REQUEST['answer2check'], 'answerID' => $_REQUEST['answer2ID'], 'questionID' => $questionID]);
                }
            }
            if(isset($_REQUEST['answer3ID'])){
                if(!isset($_REQUEST['answer3check'])){
                    $_REQUEST['answer3check'] = false;
                }else{
                    $_REQUEST['answer3check'] = true;
                }
                $answer1Update = $this->db->run("UPDATE answer SET AnswerText = :answerText, Correct = :answerCorrect WHERE AnswerID = :answerID", ['answerText' => $_REQUEST['answer3'], 'answerCorrect' => $_REQUEST['answer3check'], 'answerID' => $_REQUEST['answer3ID']]);
                if(!$answer1Update){
                    $answer1Update = $this->db->run("INSERT INTO answer (QuestionID, AnswerText, Correct) VALUES(':questionID', ':answerText', ':answerCorrect')", ['answerText' => $_REQUEST['answer3'], 'answerCorrect' => $_REQUEST['answer3check'], 'answerID' => $_REQUEST['answer3ID'], 'questionID' => $questionID]);
                }
            }
            if(isset($_REQUEST['answer4ID'])){
                if(!isset($_REQUEST['answer4check'])){
                    $_REQUEST['answer4check'] = false;
                }else{
                    $_REQUEST['answer4check'] = true;
                }
                $answer1Update = $this->db->run("UPDATE answer SET AnswerText = :answerText, Correct = :answerCorrect WHERE AnswerID = :answerID", ['answerText' => $_REQUEST['answer4'], 'answerCorrect' => $_REQUEST['answer4check'], 'answerID' => $_REQUEST['answer4ID']]);
                if(!$answer1Update){
                    $answer1Update = $this->db->run("INSERT INTO answer (QuestionID, AnswerText, Correct) VALUES(':questionID', ':answerText', ':answerCorrect')", ['answerText' => $_REQUEST['answer4'], 'answerCorrect' => $_REQUEST['answer4check'], 'answerID' => $_REQUEST['answer4ID'], 'questionID' => $questionID]);
                }
            }
        }
    }
    public function showQuestion($quizID){
        $questions = null;
        $currentQuestion = $_REQUEST['currentQuestion'];
        if($_REQUEST['currentQuestion']){
            $currentQuestion = $_REQUEST['currentQuestion'];
        }else{
            $currentQuestion = 0;
        }
        $showingAnswer = 0;
        if(!isset($_GET['QuizID'])){
            $quizID = $this->getQuizID();
        }
        if($quizID == 0){
            $quizID = $this->getQuizID();
        }
        $questions = $this->db->run("SELECT * FROM question WHERE QuizID = ? ORDER BY QuizID DESC", [$quizID])->fetchAll();
        echo("<h3>". $questions[$currentQuestion]['QuestionText']."</h3><br>");
        $answers = $this->db->run("SELECT * FROM answer WHERE QuestionID = ? ORDER BY QuestionID DESC", [$questions[$currentQuestion]['QuestionID']])->fetchAll();
        echo("<form method='POST'>");
        foreach($answers as $answer){
            $showingAnswer++;
            if($showingAnswer <= 1){
                echo("<div style='width:48%;height:20%;background-color:#eb3c3c;float:left;margin:1%;'>");
                echo("<input type='submit' style='width:100%;height:100%;border:none;background-color:#eb3c3c;font-size:2em;' value='".$answer['AnswerText']."' name='answerSubmit1'>");
            }else if($showingAnswer == 2){
                echo("<div style='width:48%;height:20%;float:left;margin:1%;'>");
                echo("<input type='submit' style='width:100%;height:100%;border:none;background-color:#52f4af;font-size:2em;' value='".$answer['AnswerText']."' name='answerSubmit2'>");
            }else if($showingAnswer == 3){
                echo("<div style='width:48%;height:20%;float:left;margin:1%;'>");
                echo("<input type='submit' style='width:100%;height:100%;border:none;background-color:#d0e55b;font-size:2em;' value='".$answer['AnswerText']."' name='answerSubmit3'>");
            }else{
                echo("<div style='width:48%;height:20%;float:left;margin:1%;'>");
                echo("<input type='submit' style='width:100%;height:100%;border:none;background-color:#4a7ceb;font-size:2em;' value='".$answer['AnswerText']."' name='answerSubmit4'>");
            }
            echo("</div>");  
        }
        echo("</form>");
    }
    public function showQuizes(){
        $user = new User();
        if($user->CheckLogin()){
        $userID = $user->getValue('UserID');
        }
        $quizes = $this->db->run("SELECT * FROM quiz WHERE UserID=?", [$userID])->fetchAll();
        foreach($quizes as $quiz){
            echo("<a href='editQuiz.php?QuizID=".$quiz['QuizID']."'><div class='quizboxdiv color-2'>");
            echo($quiz["QuizName"]. "<br><br>");
            //echo("<a style='color:#fff;' href='playQuiz.php?QuizID=".$quiz['QuizID']."'>Speel quiz</a><br>");
            echo("</div>");
        }
    }
}
?>