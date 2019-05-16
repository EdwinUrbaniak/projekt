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
    <title>Wyszukiwarka</title>
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
    <p>Szukaj po: </p>
    <form action="search.php" method="post">
        <input type="text" name="ean8" placeholder="Kod EAN-8:"/>
        <input type="text" name="title" placeholder="Tytuł:"/>
        <input type="text" name="author" placeholder="Autor:"/>
        <input type="hidden" name="actionSearch" value="true"/>
        <input type="submit" value="Szukaj" class="loginAction"/>
    </form>

    <?php
    if (!empty($_SESSION['blad'])) {
        echo $_SESSION['blad'];
        unset($_SESSION['blad']);
    }
    if (!empty($_POST['actionSearch']) && (empty($_POST['ean8']) && empty($_POST['title']) && empty($_POST['author']))) {
        $_SESSION['blad'] = 'Musisz podać min jedno kryterium.';
        header('Location: search.php');
        exit();
    } else {
        $response = [];
        if (!empty($_POST['ean8'])) {
            $query = 'SELECT * FROM books WHERE ean8=' . '\'' . $_POST['ean8'] . '\'';
            $response[] = $connection->query($query);
        }
        if (!empty($_POST['title'])) {
            $query = 'SELECT * FROM books WHERE title=' . '\'' . $_POST['title'] . '\'';
            $response[] = $connection->query($query);
        }
        if (!empty($_POST['author'])) {
            $query = 'SELECT * FROM books WHERE author=' . '\'' . $_POST['author'] . '\'';
            $response[] = $connection->query($query);
        }
        show($response);

        $connection->close();
    }

    function show($responses)
    {
        if (!empty($responses)) {
            foreach ($responses as $response) {
                foreach ($response as $row) {
                    echo '--------------------------------------------------------' . "</br>";
                    echo 'ID: ' . $row['id'] . "</br>";
                    echo 'EAN-8: ' . $row['ean8'] . "</br>";
                    echo 'Tytuł: ' . $row['title'] . "<br>";
                    echo 'Autor: ' . $row['author'] . "<br>";
                    echo 'Opis: ' . $row['description'] . "<br>";
                    echo 'Status: ' . $row['status'] . "<br>";
                }
            }
        } else {
            if (!empty($_POST['actionSearch'])) {
                $_SESSION['blad'] = 'Nic nie znaleziono!';
                unset($_SESSION['actionSearch']);
            }
        }
    }

    ?>
</div>
</body>
</html>