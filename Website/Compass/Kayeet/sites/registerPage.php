
<html>
    <head>
        <title>KaYeet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
        <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    </head>
    <body>
        <div id="titleDiv">
            <h1 id="pageTitle">
                KaYeet
            </h1>
        </div>
        <form method="post">
        <div id="contentsDiv">
                <input required='' type='text'>
                <label alt='Gebruiksnaam' placeholder='Kies een gebruiksnaam' id="usernameInputfield" name="screenName" <?php if(isset($screenName)){echo('value='.$screenName);}?>></label>
                <input required='' type='text'>
                <label alt='Email' placeholder='Typ je e-mail' id="emailInputfield" name="email" <?php if(isset($email)){echo('value='.$email);}?>></label>
                <input class="password" required='' type='password'>
                <label alt='Wachtwoord' placeholder='Verzin een wachtwoord'></label>
                <input class="password" required='' type='password'>
                <label alt='Herhaal wachtwoord' placeholder='Herhaal je wachtwoord'></label>
        </div>
        <div class="buttonDiv">
                <input type="submit" class="btn-hover color-1" name="submitRegistration" value="Registreren">
                <button class="btn-hover color-1">Login?</button> 
        </div>
    </form>
    </body>
</html>