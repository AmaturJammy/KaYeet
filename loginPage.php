<?php
require_once 'config.php';
$message = "";

$user = new User();
$logged_in = $user->checkLogin();
//echo(var_export($logged_in));

if(isset($_POST['submitinlog'])){
    $email = $_POST['email'];
    $wachtwoord = $_POST['password'];

    if(empty($email) || empty($wachtwoord)){
        $message = "Niet alle velden zijn ingevoerd";
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = "Email is niet geldig";
    }else{
        $user = new User();
        if($user->CheckLogin($_POST)){
            header("Location: control.php");
            exit;
        }
    }
}


?>
<html>
<head>
    <title>KaYeet | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="Resources/stylesheets/stylesheet.css">
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
            <input required name="email" type='text'>
            <label alt='Email' placeholder='Typ je e-mail'></label>
            <input class="password" name="password" required type='password'>
            <label alt='Wachtwoord' placeholder='Verzin een wachtwoord'></label>
        </div>
        <div class="buttonDiv">
            <button class="btn-hover color-1" onclick="location.href='registerPage.php'">Registreren</button>
            <input type="submit" name="submitinlog" class="btn-hover color-1" value="Inloggen">
        </div>
        <?php echo("<center><p style='color:#fff;'>". $message. "</p></center>");?>
    </form>
</body>
</html>