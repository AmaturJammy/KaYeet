<?php
require_once 'config.php';
$message = "";

$user = new User();
$logged_in = $user->checkLogin();

if($logged_in){
    header("Location: control.php");
    exit;
}

if(isset($_POST['submitRegistration'])){
    $screenName = $_POST['screenName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if(empty($screenName) || empty($email) || empty($password) || empty($confirmPassword)){
        $message = "Niet alle velden zijn ingevoerd";
    }else if($password != $confirmPassword){
        $message = "De ingevoerde wachtwoorden komen niet overeen";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Het ingevoerde email adres is niet geldig";
    }else{
        $user = new User();
        $registrationSucces = $user->register($_POST);

        if($registrationSucces){
            $message = "Account is gemaakt!";
            header("Location: loginPage.php");
            exit;
        }else{
            $message = "Account heeft niet aangemaakt kunnen worden. Probeer het later opnieuw!";
        }
    }
}
?>
<html>
<head>
    <title>KaYeet | Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/Kayeet/Resources/stylesheets/stylesheet.css">
    <script type="text/javascript" src="Resources/javascript/script.js"></script>
</head>
<body>
    <div id="titleDiv">
        <h1 onclick="location.href='control.php'" id="pageTitle">
            KaYeet
        </h1>
    </div>
    <form method="post">
    <div id="contentsDiv">
            <input name="screenName" required='' type='text'>
            <label alt='Gebruiksnaam' placeholder='Kies een gebruiksnaam' id="usernameInputfield" <?php if(isset($screenName)){echo('value='.$screenName);}?>></label>
            <input name="email" required='' type='text'>
            <label alt='Email' placeholder='Typ je e-mail' id="emailInputfield" <?php if(isset($email)){echo('value='.$email);}?>></label>
            <input name="password" class="password" required='' type='password'>
            <label alt='Wachtwoord' placeholder='Verzin een wachtwoord'></label>
            <input name="confirmPassword" class="password" required='' type='password'>
            <label alt='Herhaal wachtwoord' placeholder='Herhaal je wachtwoord'></label>
    </div>
    <div class="buttonDiv">
            <input type="submit" class="btn-hover color-1" name="submitRegistration" value="Registreren">
            <button class="btn-hover color-1" onclick="location.href='loginPage.php'">Login?</button> 
    </div>
    <?php echo("<center><p style='color:#fff;'>". $message. "</p></center>");?>
    </form>
</body>
</html>