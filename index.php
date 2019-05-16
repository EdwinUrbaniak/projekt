<?php

session_start();

if (!empty($_SESSION['logged'])) {
    header('Location: logged.php');
    exit();
}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <title>Biblioteka</title>

    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext"
          rel="stylesheet">
</head>

<body>
<div class="container">

    <header>
        <h1>Biblioteka</h1>
    </header>

    <main>
        <article>
            <form action="login.php" method="post">
                Login lub EAN-8: <br/> <input type="text" name="login" title="login" required/> <br/>
                Hasło: <br/> <input type="password" name="pass" title="password" required/> <br/><br/>
                <input type="submit" class="loginAction" value="Zaloguj się"/>
            </form>
            <?php
            if (!empty($_SESSION['blad'])) {
                echo $_SESSION['blad'];
            }
            ?>
        </article>
    </main>

</div>
</body>
</html>

