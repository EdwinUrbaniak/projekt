<?php
require_once "config.php";
require_once "connection.php";

session_start();

if (empty($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="main.css">
    <title>Panel zalogowanego</title>
</head>
<body>

<div class="container">
    <main>
        <article>
            <header>
                <h4>
                    <?php
                    $user = $_SESSION['user'];
                    echo "<p>Witaj " . $user['name'] . '(EAN-8:' . $user['ean8'] . ')' . ' [ <a href="logout.php">Wyloguj się!</a> ]</p>';
                    ?>
                </h4>
            </header>

            <form action="mainBorrows.php" method="post">
                <input type="submit" value="Moje wypożycznenia" class="otherAction"/>
            </form>

            <form action="books.php" method="post">
                <input type="submit" value="Książki" class="otherAction"/>
            </form>

            <form action="search.php" method="post">
                <input type="submit" value="Wyszukiwarka" class="otherAction"/>
            </form>

            <form action="history.php" method="post">
                <input type="submit" value="Historia wypożyczeń" class="otherAction"/>
            </form>
        </article>
    </main>
</div>
</body>
</html>