<?php
require_once "config.php";
require_once "connection.php";

session_start();

$connection = Connection::getConnection();
$user = $_SESSION['user'];

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
}

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
    <title>Historia Wypożyczeń</title>
</head>
<body>

<div class="container">
    <main>
        <article>

            <header>
                <h4>
                    <?php
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
            <br>
        </article>
    </main>
</div>
<div class="containerLogged">
    <?php
    $allMyBorrows = 'SELECT * FROM history WHERE user_id=' . '\'' . $user['id'] . '\'';
    if ($rows = $connection->query($allMyBorrows)) {
        echo "Moja historia wypożyczeń: <br><br>";
        foreach ($rows as $row) {
            echo '--------------------------------------------------------' . "</br>";
            echo 'ID: ' . $row['id'] . "</br>";
            echo 'ID książki: ' . $row['book_id'] . "<br>";
            echo 'Data wypożyczenia: ' . $row['date_borrow'] . "<br>";
            echo 'Data oddania: ' . $row['date_return'] . "<br>";
        }
        echo '--------------------------------------------------------';
    } else {
        $_SESSION['blad'] = 'Błąd sql';
    }
    ?>
    <div>
</body>
</html>