
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
            <input type="text" required placeholder="Naam:" class="defaultInputfield" name="screenName" <?php if(isset($screenName)){echo('value='.$screenName);}?>><br>
            <input type="email" required placeholder="E-Mail:" class="defaultInputfield" name="email" <?php if(isset($email)){echo('value='.$email);}?>><br>
            <input type="password" required placeholder="Wachtwoord:" class="defaultInputfield" name="password"><br>
            <input type="password" required placeholder="Bevestig WW:" class="defaultInputfield" name="confirmPassword"><br>
            <input type="submit" required class="defaultButton" name="submitRegistration" value="Registreer">
        </form>
    </div>
</body>
</html>


