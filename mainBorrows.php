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
    <title>Moje Wypożyczenia</title>
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
    $allMyBorrows = 'SELECT * FROM borrows WHERE user_id=' . '\'' . $user['id'] . '\'';
    if ($rows = $connection->query($allMyBorrows)) {
        echo "Moje aktualne wypożyczenia: <br><br>";
        if ($rows->num_rows != 0) {
            foreach ($rows as $row) {
                echo '--------------------------------------------------------' . "</br>";
                echo 'ID: ' . $row['id'] . "</br>";
                echo 'ID książki: ' . $row['book_id'] . "<br>";
                echo 'Data wypożyczenia: ' . $row['date_borrow'] . "<br>"; ?>
                <form action="mainBorrows.php" method="post">
                    <input type="hidden" name="borrowId" value="<?= $row['id'] ?>"/>
                    <input type="hidden" name="bookId" value="<?= $row['book_id'] ?>"/>
                    <input type="hidden" name="borrowDate" value="<?= $row['date_borrow'] ?>"/>
                    <input type="submit" value="Zwrot"/>
                </form>
                <?php
            }
            echo '--------------------------------------------------------';
        } else {
            echo 'Brak wypożyczeń';
        }
    } else {
        $_SESSION['blad'] = 'Błąd sql';
    }

    if (!empty($_POST['borrowId']) && !empty($_POST['bookId']) && !empty($_POST['borrowDate'])) {
        $query = 'UPDATE books SET status=' . '\'DOSTEPNA\'' . ' WHERE id=' . $_POST['bookId'];
        $response = $connection->query($query);
        $query = 'DELETE FROM borrows WHERE id=' . $_POST['borrowId'];
        $response = $connection->query($query);
        $query = 'INSERT INTO `history` (`user_id`, `book_id`, `date_borrow`, `date_return`) VALUES (' . $user['id'] . ', ' . $_POST['bookId'] . ',' . '\'' . $_POST['borrowDate'] . '\'' . ', CURRENT_TIME())';
        $response = $connection->query($query);
        $connection->close();
        header('Location: mainBorrows.php');
    }

    $connection->close();
    ?>
    <div>
</body>
</html>