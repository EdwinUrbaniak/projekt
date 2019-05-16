<?php
require_once "config.php";
require_once "Connection.php";

session_start();
if (!isset($_POST['login']) || !isset($_POST['pass'])) {
    header('Location: index.php');
    exit();
}

$dataBase = Connection::getConnection();

if ($dataBase->connect_errno != 0) {
    echo "Error: " . $dataBase->connect_errno;
} else {
    if (is_numeric($_POST['login']) && strlen($_POST['login']) == 8) {
        $query = 'SELECT * FROM users WHERE ean8=' . '\'' . $_POST['login'] . '\'';
    } else {
        $query = 'SELECT * FROM users WHERE login=' . '\'' . $_POST['login'] . '\'';
    }
    $pass = $_POST['pass'];
    if ($row = $dataBase->query($query)->fetch_assoc()) {
        if ($pass == $row['pass']) {
            $_SESSION['logged'] = true;
            $_SESSION['user'] = $row;
            unset($_SESSION['blad']);
            header('Location: logged.php');
        } else {
            $_SESSION['blad'] = 'Nieprawidłowy login lub hasło!';
            header('Location: index.php');
        }
    } else {
        $_SESSION['blad'] = 'Nie ma takiego użytkownika!';
        header('Location: index.php');
    }
    $dataBase->close();
}