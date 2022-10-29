<?php 
require_once('../includes/session.php');
if (!isset($_SESSION['user_token'])) {
    session_destroy();
    header("Location: ../login/");
    die();
} else {
    require_once '../includes/functions.php';
    $options = array(
        'options' => array(
            'default' => 0, // value to return if the filter fails
        ),
    );
    $user_id = intval($_SESSION['session_user']);
    $username = clean_data($_SESSION['session_username']);
    $user_id = filter_var($user_id, FILTER_VALIDATE_INT, $options);
    if (!isset($_POST['spedisci']) || !isset($_POST['spedito'])) {
        header("Location: index.php");
        die();
    }
    $book_id = $_POST['spedito'];
    $book_id = intval($book_id);
    $book_id = filter_var($book_id, FILTER_VALIDATE_INT, $options);
    if ($book_id === 0) {
        header("Location: index.php");
        die();
    }
    if ($user_id === 0) {
        header("Location: ../login/");
        die();
    }
    
    //prendo il titolo del libro 
    $sql = "SELECT * FROM books WHERE user_id = :seller_id AND id = :book_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':seller_id',$user_id,PDO::PARAM_INT);
    $stmt->bindParam(':book_id',$book_id,PDO::PARAM_INT);
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
    $book_title = $rows[0]['title'];
    
    //controllo che ci sia un libro con quel book_id che appartenga a questo user che ancora non è stato spedito
    $sql = "SELECT * FROM orders WHERE seller_id = :seller_id AND status = 0 AND book_id = :book_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':seller_id',$user_id,PDO::PARAM_INT);
    $stmt->bindParam(':book_id',$book_id,PDO::PARAM_INT);
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
    $acquirente = $rows[0]['buyer_id'];
    $order_id = $rows[0]['id'];
    

    //ora aggiorno ponendo lo status dell'ordine a 1 --> ordine spedito
    $sql = "UPDATE orders set status = 1 WHERE seller_id = :seller_id AND status = 0 AND book_id = :book_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':seller_id',$user_id,PDO::PARAM_INT);
    $stmt->bindParam(':book_id',$book_id,PDO::PARAM_INT);
    if (!$stmt->execute()) {
        header("Location: index.php");
        die();
    }
    
    //prendo la mail dell'acquirente e invio la mail di conferma spedizione
    $sql = "SELECT * FROM users WHERE id = :acquirente";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':acquirente',$acquirente,PDO::PARAM_INT);
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
    $emailAcquirente = $rows[0]['email'];
    $emailSent = sendMail($emailAcquirente,$order_id,$username,$book_title);
    
    header("Location: index.php?res=spedito");
    die();
    
    
    
}


function sendMail($emailDest,$order,$venditore,$titolo) {
    error_reporting(E_ALL);

    // Genera un boundary
    $mail_boundary = "=_NextPart_" . md5(uniqid(time()));
    
    $to = $emailDest;
    $subject = "Spedizione effettuata";
    $sender = "Ordine spedito < postmaster@bibliontech.it >";
    
    
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
    $msg .= "Ordine Spedito. Il venditore $venditore ha correttamente inserito la spedizione per l'ordine $order corrispondente al libro $titolo. Quando riceverai il libro, aggiorna lo status entro 2 giorni
    nella sezione 'Acquisti'. Grazie, lo staff di BiblionTech";  // aggiungi il messaggio in formato text
     
    $msg .= "\n--$mail_boundary\n";
    $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "<h2>Ordine Spedito</h2><p>Il venditore <strong>$venditore</strong> ha correttamente inserito la spedizione per l'ordine <strong>$order</strong> corrispondente al libro <strong>$titolo</strong>. Quando riceverai il libro, aggiorna lo status entro 2 giorni
    nella sezione 'Acquisti'.</p><br><p> Grazie, lo staff di BiblionTech</p>";   // aggiungi il messaggio in formato HTML
     
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
?>