<?php
require_once "config.php";
require_once "connection.php";

session_start();

$connection = Connection::getConnection();
$user = $_SESSION['user'];

if (empty($_SESSION['logged'])) {
    header('Location: index.php');
    exit();
}

if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
}

if (!empty($_POST['bookId'])) {
    $query = 'UPDATE books SET status=' . '\'WYPOZYCZONA\'' . 'WHERE id=' . $_POST['bookId'];
    $response = $connection->query($query);
    $query = 'INSERT INTO `borrows` (`user_id`, `book_id`, `date_borrow`) VALUES (' . $user['id'] . ', ' . $_POST['bookId'] . ', CURRENT_TIME())';
    $response = $connection->query($query);
    header('Location: books.php');
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="main.css">
    <title>Książki</title>
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
    $allBooks = 'SELECT * FROM books';
    if ($rows = $connection->query($allBooks)) {
        echo "Książki: <br><br>";
        foreach ($rows as $row) {
            echo '--------------------------------------------------------' . "</br>";
            echo 'ID: ' . $row['id'] . "</br>";
            echo 'EAN-8: ' . $row['ean8'] . "</br>";
            echo 'Tytuł: ' . $row['title'] . "<br>";
            echo 'Autor: ' . $row['author'] . "<br>";
            echo 'Opis: ' . $row['description'] . "<br>";
            echo 'Status: ' . $row['status'] . "<br>";
            if ($row['status'] == 'DOSTEPNA') { ?>
                <form action="books.php" method="post">
                    <input type="hidden" name="bookId" value="<?= $row['id'] ?>"/>
                    <input type="submit" value="Wypożycz"/>
                </form>
                <?php
            } ?>
            <?php
        }
        echo '--------------------------------------------------------' . "</br>";
    } else {
        $_SESSION['blad'] = 'Błąd sql';
    }
    $connection->close();
    ?>
</div>
</body>
</html>