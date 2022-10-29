<?php

require_once('../includes/functions.php');

//eliminazione libro
if (isset($_POST['book'])) {
    $book_id = $_POST['book'];
    $book_id = intval($book_id);
    $book_id = filter_var($book_id, FILTER_VALIDATE_INT);
    if ($book_id === 0) {
        header('location: index.php');
        die();
    }

    //check if book is in some orders not completed
    $sql = "SELECT * FROM orders WHERE book_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $book_id);
    if (!$stmt->execute()) {
        header('location: index.php?page=books');
        die();
    }
    $rows = $stmt->rowCount();
    if ($rows > 0) {
        header('location: index.php?ordini=true&page=books');
        die();
    }
    //se non è così elimino il book
    $sql = "DELETE FROM books WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $book_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
        header('location: index.php?page=books');
        die();
    }

    removeBookDir($book_id);
    header('location: index.php?success=true&page=books');
    die();
}

//eliminazione user
if (isset($_POST['user'])) {
    $user_id = $_POST['user'];
    $user_id = intval($user_id);
    $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
    if ($user_id === 0) {
        header('location: index.php?page=user');
        die();
    }


    //check if user has some orders not completed
    $sql = "SELECT * FROM orders WHERE (seller_id = :seller_id OR buyer_id = :buyer_id) AND status != 2";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':buyer_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':seller_id', $user_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
        header('location: index.php?page=user');
        die();
    }
    $rows = $stmt->rowCount();
    if ($rows > 0) {
        header('location: index.php?error=true&page=user');
        die();
    }

    //elimino l'indirizzo dell'utente
    $sql = "DELETE FROM address WHERE user_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        if (intval($e->getCode()) === 23000) {
            header('location: index.php?code=23000');
            die();
        }
        header('location: index.php?page=user');
        die();
    }

    //elimino le recensioni dell'utente
    $sql = "DELETE FROM recensioni WHERE recensore = :id OR recensito = :recensito";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':recensito', $user_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        if (intval($e->getCode()) === 23000) {
            header('location: index.php?code=23000');
            die();
        }
        header('location: index.php?page=user');
        die();
    }


    //elimino il saldo dell'utente
    $sql = "DELETE FROM saldo WHERE user_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        if (intval($e->getCode()) === 23000) {
            header('location: index.php?code=23000&page=user');
            die();
        }
        header('location: index.php?page=user');
        die();
    }

    //prendo l'username dell'utente per poi eliminare la sua directory
    $sql = "SELECT username FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    $usernameToDelete = $row['username'];

    //se non è così elimino l'utente ma prima elimno
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    try {
        $stmt->execute();
    } catch (Exception $e) {
        if (intval($e->getCode()) === 23000) {
            header('location: index.php?code=23000&page=user');
            die();
        }
        header('location: index.php?page=user');
        die();
    }

    removeUserDir($usernameToDelete);
    header('location: index.php?success=true&page=user');
    die();
}

//eliminazione ordine

if (isset($_POST['order'])) {
    $order_id = $_POST['order'];
    $order_id = clean_data($order_id);

    //check if user has some orders not completed
    $status = $_POST['status'];
    $status = clean_data($status);

    if ($status === 'non spedito') {
        header('location: index.php?error=true&page=orders');
        die();
    }
    if ($status === 'spedito') {
        header('location: index.php?error=true&page=orders');
        die();
    }

    //elimino l'ordine solo se è stato consegnato
    if ($status === 'consegnato') {
        $sql = "DELETE FROM orders WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $order_id);
        if (!$stmt->execute()) {
            header('location: index.php?error=true&page=orders');
            die();
        }
        header('location: index.php?success=true&page=orders');
        die();
    }
    header('location: index.php?error=true&page=orders');
    die();


    //se non è così elimino il book
}

function removeBookDir($id)
{
    $dirname = "../books/" .$id. "/";
    array_map('unlink', glob("$dirname/*.*"));

    rmdir($dirname);
}
function removeUserDir($username)
{
    $dirname = "../users/" .$username. "/";
    array_map('unlink', glob("$dirname/*.*"));

    rmdir($dirname);
}
