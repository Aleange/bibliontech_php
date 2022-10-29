<?php

require_once('../includes/session.php');
if (!isset($_SESSION['user_token'])) {
    session_destroy();
    header("Location: ../login/");
    die();
} else {
    if ($_SESSION['active'] === false) {
        $active = false;
        header('location: ../my_account/');
        die();
    }

    require_once '../includes/functions.php';
    $options = array(
        'options' => array(
            'default' => 0, // value to return if the filter fails
        ),
    );
    $user_id = intval($_SESSION['session_user']);
    $user_id = filter_var($user_id, FILTER_VALIDATE_INT, $options);
    $usernameAcquirente = clean_data($_SESSION['session_username']);
    if (!isset($_POST['consegna']) || !isset($_POST['consegnato']) || !isset($_POST['seller'])) {
        header("Location: index.php");
        die();
    }

    //prendo l'id del venditore
    $seller_id = $_POST['seller'];
    $seller_id = intval($seller_id);
    $seller_id = filter_var($seller_id, FILTER_VALIDATE_INT, $options);

    //prendo l'id del libro
    $book_id = $_POST['consegnato'];
    $book_id = intval($book_id);
    $book_id = filter_var($book_id, FILTER_VALIDATE_INT, $options);


    if ($seller_id === 0) {
        header("Location: index.php");
        die();
    }
    if ($book_id === 0) {
        header("Location: index.php");
        die();
    }
    if ($user_id === 0) {
        header("Location: ../login/");
        die();
    }

    //controllo che ci sia un libro con quel book_id che appartenga a questo user che ancora non è stato spedito
    $sql = "SELECT * FROM orders WHERE buyer_id = :buyer_id AND seller_id = :seller_id AND status = 1 AND book_id = :book_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':buyer_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
        header("Location: index.php");
        die();
    }
    $numRows = $stmt->rowCount();
    if ($numRows === 0 || $numRows !== 1) {
        header("Location: index.php");
        die();
    }
    $rows = $stmt->fetchAll();
    $lordo = $rows[0]['price'];
    $order_id = $rows[0]['id'];


    //ora aggiorno ponendo lo status dell'ordine a 1 --> ordine spedito
    $sql = "UPDATE orders set status = 2 WHERE buyer_id = :buyer_id AND  seller_id = :seller_id AND status = 1 AND book_id = :book_id AND id = :order_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':buyer_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':seller_id', $seller_id, PDO::PARAM_INT);
    $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
        header("Location: index.php");
        die();
    }

    //aggiorno il saldo dell'utente che ha venduto il libro
    $commissione = ($lordo * 5)/100;
    $netto = $lordo - $commissione;

    $query3 = "UPDATE saldo SET lordo = lordo + :lordo,commissione = commissione + :commissione
    , netto = netto + :netto WHERE user_id = :seller_id";
    $check3 = $pdo->prepare($query3);
    $check3->bindParam(':lordo', $lordo);
    $check3->bindParam(':commissione', $commissione);
    $check3->bindParam(':netto', $netto);
    $check3->bindParam(':seller_id', $seller_id);
    if (!$check3->execute()) {
        header("Location: index.php?res=errore");
        die();
    }

    $query2 = "SELECT id,email,username FROM users WHERE id = :seller_id";
    $statement2 = $pdo->prepare($query2);
    $statement2->bindParam(':seller_id', $seller_id);
    if (!$statement2->execute()) {
        header("Location: index.php?res=errore");
        die();
    }
    $users = $statement2->fetchAll(PDO::FETCH_ASSOC);
    $user_email = $users[0]['email'];
    //inviamo la mail all'utente venditore che l'ordine è stato consegnato
    $sentEmail = sendMail($user_email, $order_id, $usernameAcquirente);

    header("Location: index.php?res=consegnato");
    die();
}


function sendMail($emailDest, $order, $acquirenteX)
{
    error_reporting(E_ALL);

    // Genera un boundary
    $mail_boundary = "=_NextPart_" . md5(uniqid(time()));

    $to = $emailDest;
    $subject = "Consegna avvenuta";
    $sender = "BiblionTech < postmaster@bibliontech.it >";


    $headers = "From: $sender\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/alternative;\n\tboundary=\"$mail_boundary\"\n";
    $headers .= "X-Mailer: PHP " . phpversion();

    // Corpi del messaggio nei due formati testo e HTML
    $text_msg = "messaggio in formato testo";
    $html_msg = "<b>messaggio</b> in formato <p><a href='http://www.aruba.it'>html</a><br><img src=\"http://hosting.aruba.it/image_top/top_01.gif\" border=\"0\"></p>";

    // Costruisci il corpo del messaggio da inviare
    $msg = "This is a multi-part message in MIME format.\n\n";
    $msg .= "--$mail_boundary\n";
    $msg .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "Ordine Consegnato. L'acquirente $acquirenteX ha correttamente inserito la consegna per l'ordine $order. Ora l'incasso è disponibile nel tuo saldo. Grazie, lo staff di BiblionTech";  // aggiungi il messaggio in formato text

    $msg .= "\n--$mail_boundary\n";
    $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "<h2>Ordine Consegnato</h2><p>L'acquirente $acquirenteX ha correttamente inserito la consegna per l'ordine $order. Ora l'incasso è disponibile nel tuo saldo.</p><br><p> Grazie, lo staff di BiblionTech</p>";   // aggiungi il messaggio in formato HTML

    // Boundary di terminazione multipart/alternative
    $msg .= "\n--$mail_boundary--\n";

    // Imposta il Return-Path (funziona solo su hosting Windows)
    ini_set("sendmail_from", $sender);

    // Invia il messaggio, il quinto parametro "-f$sender" imposta il Return-Path su hosting Linux
    if (mail($to, $subject, $msg, $headers, "-f$sender")) {
        return true;
    } else {
        return false;
    }
}
