
<html>
<head>
	<title>KaYeet register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="../stylesheets/style.css">
</head>
<body>
    <div id="titleTextDiv">
        <h1 id="pageTitle">
            KaYeet
        </h1>
    </div>
    <div id="contentsDiv">
         <form method="post">
            <input type="text" placeholder="Gebruikersnaam" id="usernameInputfield" name="screenName" <?php if(isset($screenName)){echo('value='.$screenName);}?>><br>
            <input type="email" placeholder="E-Mail" id="emailInputfield" name="email" <?php if(isset($email)){echo('value='.$email);}?>><br>
            <input type="password"  placeholder="Wachtwoord" id="passwordInputfield1" name="password"><br>
            <input type="password"  placeholder="Bevestig WW" id="passwordInputfield2" name="confirmPassword"><br>
            <input type="submit" id="defaultButton" name="submitRegistration" value="Registreren">
        </form>
    </div>
</body>
</html>


