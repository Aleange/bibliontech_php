<?php
require_once('../includes/session.php');
if (!isset($_SESSION['user_token'])) {
    session_destroy();
    header("Location: ../login/");
    die();
} else {
    require_once '../includes/functions.php';
    if ($_SESSION['active'] === false) {
        header("Location: ../my_account/");
        die();
    }
    $options = array(
        'options' => array(
            'default' => 0, // value to return if the filter fails
        ),
    );
    $user_id = intval($_SESSION['session_user']);
    $user_id = filter_var($user_id, FILTER_VALIDATE_INT, $options);
    $user_token = $_SESSION['user_token'];
    if ($user_id === 0) {
        header("Location: ../login/");
        die();
    } else {
        $sql = "SELECT `netto` FROM `saldo` WHERE `user_id` = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll();
        $saldo = $result[0]['netto'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BiblionTech</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../assets/css/account.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/form.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/typewriter.css">
    <style>
    .form {
        position: relative;
        background-color: #F7F9F9;
        border-radius: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 30px 50px;
        height: 100%;
        text-align: center;
    }

    input#prezzo {
        width: 40%;
        margin-left: 30%;
        margin-right: 30%;
        text-align: center;
    }
    </style>
</head>


<body>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center"
                href="https://bibliontech.it/"><span>BiblionTech</span></a><button data-bs-toggle="collapse" class="navbar-toggler"
                data-bs-target="#navcol-1"><span class="navbar-toggler-icon"><svg xmlns="http://www.w3.org/2000/svg"
                        width="1em" height="1em" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M22 18.0048C22 18.5544 21.5544 19 21.0048 19H12.9952C12.4456 19 12 18.5544 12 18.0048C12 17.4552 12.4456 17.0096 12.9952 17.0096H21.0048C21.5544 17.0096 22 17.4552 22 18.0048Z"
                            fill="currentColor"></path>
                        <path
                            d="M22 12.0002C22 12.5499 21.5544 12.9954 21.0048 12.9954H2.99519C2.44556 12.9954 2 12.5499 2 12.0002C2 11.4506 2.44556 11.0051 2.99519 11.0051H21.0048C21.5544 11.0051 22 11.4506 22 12.0002Z"
                            fill="currentColor"></path>
                        <path
                            d="M21.0048 6.99039C21.5544 6.99039 22 6.54482 22 5.99519C22 5.44556 21.5544 5 21.0048 5H8.99519C8.44556 5 8 5.44556 8 5.99519C8 6.54482 8.44556 6.99039 8.99519 6.99039H21.0048Z"
                            fill="currentColor"></path>
                    </svg></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/acquista/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/acquisti/">Acquisti</a></li>
                    <li class="nav-item"><a class="nav-link active" href="javascript:void(0);">Vendite</a></li>
                </ul><a href="https://bibliontech.it/login/logout.php?token=<?php echo $user_token;?>">Logout</a>
                <a class='btn nav-btn click' type='button' href='../my_account/'>
                    <i class='far fa-user'></i></a>
            </div>
        </div>
    </nav>
    <section>
        <div class="max-width">
            <div class="container">
                <div class="row" style="position: sticky;">
                    <div class="col order-sm-1">
                        <div class="d-flex justify-content-center"><button class="btn round-btn shadow-none click"
                                id="add-book-open" type="button"><i class="fas fa-plus"></i></button></div>
                    </div>
                    <div
                        class="col-12 col-sm-auto d-flex justify-content-center align-items-center order-first order-sm-2">
                        <h1>Le tue vendite</h1>
                    </div>
                    <div class="col order-sm-3">
                        <div class="d-flex justify-content-center"><button class="btn round-btn shadow-none click"
                                id="get-cash-open" type="button"><i class="fas fa-wallet"></i></button></div>
                    </div>
                </div>
            </div>
            <span id="spedito" style="color:green;display:none;">
                Status libro aggiornato
            </span>

            <span id="eliminato" style="color:green;display:none;">
                Libro eliminato con successo
            </span>
            
            <span id="errore" style="color:red;display:none;">
                Non puoi eliminare questo libro
            </span>
            
            <span id="saldo" style="color:green;display:none;">
                Saldo richiesto con successo
            </span>
            
            <div class="container">
                <div class="row">
                    <div class="col">


                        <div id="add-book1" class="add-book">
                            <div class="small-form-container">
                                <div class="form"><button class="btn btn-close shadow-none click" id="add-book-close1"
                                        type="button"></button>
                                    <h1>Aggiungi libro</h1>
                                    <span>Inserisci le informazioni del libro</span>
                                    <input class="form-control" id="isbn" type="text" placeholder="ISBN" required="true"
                                        name="isbn" minlength="13" maxlength="13">
                                    <a id="no-isbn-link" href="#">non disponi di un ISBN?</a>
                                    <button class="btn form-button click shadow-none"
                                        onclick="getInfo()">Conferma</button>
                                </div>
                            </div>
                        </div>


                        <!--FORM PER VENDERE LIBRO -->
                        <div id="add-book2" class="add-book">
                            <div class="small-form-container">
                                <div class="form">
                                    <form class="adding" method="POST" action="index.php" onsubmit="return checkBook()"
                                        enctype="multipart/form-data">

                                        <button class="btn btn-close shadow-none click" id="add-book-close2"
                                            type="button"></button>
                                        <h1>Aggiungi libro</h1><span>Inserisci le informazioni del libro</span>

                                        <label id="fail1" style="display: none;color:red;">Compila i campi
                                            richiesti</label>

                                        <input class="form-control" type="text" placeholder="Titolo*" required="true"
                                            id="titolo" name="titolo">

                                        <input class="form-control" type="text" placeholder="Autore*" required="true"
                                            id="autore" name="autore">

                                        <input class="form-control" type="text" placeholder="ISBN" minlength="13"
                                            maxlength="13" id="isbn1" name="isbn">

                                        <button class="btn form-button click shadow-none"
                                            id="next-btn1">Continua</button>
                                </div>
                            </div>
                        </div>


                        <div id="add-book3" class="add-book">
                            <div class="small-form-container">
                                <div class="form">
                                    <button class="btn btn-close shadow-none click" id="add-book-close3"
                                        type="button"></button>
                                    <h1>Aggiungi libro</h1>
                                    <span>Inserisci le informazioni del libro</span>

                                    <textarea class="form-control" required="true" placeholder="Descrizione*"
                                        name="descrizione" id="descrizione" maxlength="500"></textarea>

                                    <span>Foto</span>
                                    <input class="form-control" id="sel-copertina" type="file" required="true"
                                        multiple="true" name="files[]">
                                    <img id="immagine-libro" style="display: none" src="" />
                                    
                                    <input type="hidden" id="foto" name="foto" value="" />

                                    <div class="d-sm-flex align-items-md-center"><span>Condizioni</span>
                                        <br>
                                        <div class="rating-css">
                                            <div class="star-icon">
                                                <input type="radio" name="condizioni" value="1" id="rating1">
                                                <label for="rating1" class="fa fa-book"></label>
                                                <input type="radio" name="condizioni" value="2" id="rating2">
                                                <label for="rating2" class="fa fa-book"></label>
                                                <input type="radio" name="condizioni" value="3" id="rating3">
                                                <label for="rating3" class="fa fa-book"></label>
                                                <input type="radio" name="condizioni" value="4" id="rating4">
                                                <label for="rating4" class="fa fa-book"></label>
                                                <input type="radio" name="condizioni" value="5" id="rating5">
                                                <label for="rating5" class="fa fa-book"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <span>Prezzo</span>
                                    <div class="range-input">
                                        <input type="number" name="prezzo" id="prezzo" class="form-control price"
                                            required="true" min="1" step="0.01">
                                    </div>

                                    <button class="btn form-button click shadow-none" id="next-btn-1" type="submit"
                                        name="sell-submit">
                                        Conferma
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--FINE FORM PER VENDERE IL LIBRO -->


                        <!--CONFERMA DELLA SCELTA DEL LIBRO-->
                        <div id="confirm-book" class="add-book">
                            <div class="small-form-container">
                                <div class="form">
                                    <h1>Conferma</h1>
                                    <div class="form-book">
                                        <div class="book-img"><img id="copertina" src=""></div>
                                    </div><span>è questo il tuo libro?</span>
                                    <div class="d-flex align-items-center">
                                        <button class="round-btn click shadow-none" id="no-confirm" type="button" style="background: rgb(255,15,0);">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button class="round-btn click shadow-none" id="yes-confirm" type="button">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--FINE CONFERMA SCELTA LIBRO-->
                        
                        <!--CONFERMA ELIMINAZIONE LIBRO-->
                        <div id="delete-book" style="display:none;" class="add-book">
                            <div class="small-form-container">
                                <div class="form">
                                    <form action="index.php" method="post">
                                    <h1>Conferma</h1>
                                    <!-- <div class="form-book"></div> -->
                                    <span>Sei sicuro di voler eliminare questo libro?</span>
                                     <input hidden type="text" id="libro-da-eliminare" required="true" name="libro-eliminato">
                                    <div class="d-flex align-items-center">
                                        <button class="round-btn click shadow-none" id="no-confirm" onclick="notDisplayDelete()" type="button" style="background: rgb(255,15,0);">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button class="round-btn click shadow-none" id="yes-confirm" name="elimina" value="si" type="submit">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--FINE CONFERMA ELIMINAZIONE LIBRO-->


                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div id="get-cash" class="add-book">
                            <div class="small-form-container">

                                <!--FORM PER RICHIEDERE IL SALDO-->
                                <?php 
                                
                                if (intval($saldo) < 15) {
                                    echo '<form>';
                                } else {
                                    echo '
                                    <form action="index.php" method="post">
                                    ';
                                }

                                ?>

                                <button class="btn btn-close shadow-none click" id="get-cash-close"
                                    type="button"></button>
                                <h1>Riscuoti saldo</h1>
                                <span>Saldo disponibile&nbsp;<span>
                                        <strong id='saldo-disponibile'>
                                            <?php echo $saldo; ?>
                                        </strong>
                                    </span>
                                    <strong>€</strong><br>
                                </span>

                                <!--errori-->
                                <span id="obbligatori" style="color:red;display:none;">Tutti i campi sono
                                    obbligatori</span>
                                <span id="insufficiente" style="color:red;display:none;">Saldo insufficiente</span>
                                <span id="errata" style="color:red;display:none;">Password errata</span>
                                <span id="iban" style="color:red;display:none;">Devi inserire un IBAN valido</span>
                                <span id="generico" style="color:red;display:none;">Errore generico</span>
                                <span id="nome" style="color:red;display:none;">Nome e/o Cognome non valido</span>
                                <!--fine errori-->

                                <input class="form-control" type="password" placeholder="Password" name="password-saldo"
                                    required="true">

                                <div class="d-flex align-items-center">
                                    <input type="checkbox" required="false" name="checkbox-saldo" style="width: auto;">
                                    <span style="padding-left:5px;">Accetto&nbsp;<a href="https://bibliontech.it/about/terms_and_conditions.html" style="font-size: 16px;"><strong>Termini e
                                                Condizioni</strong></a>&nbsp;</span>

                                    
                                </div>
                                <?php 
                                    
                                    if (intval($saldo) < 15) {
                                        echo '
                                        <button class="btn form-button click shadow-none" type="button"
                                        name="get-saldo" onclick=showErrorSaldo();>Riscuoti</button>
                                        ';
                                    } else {
                                        echo '<button class="btn form-button click shadow-none" type="submit"
                                        name="get-saldo">Riscuoti</button>';
                                    }

                                    ?>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--CONTAINER LIBRI-->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="books-container">

                            <?php

                            require_once '../includes/functions.php';
                            getBooksSold($user_id);
                            
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <?php require_once('../includes/footer.php'); ?>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/form.js"></script>
    <script src="../assets/js/sell.js"></script>
    <script src="../assets/js/typewriter.js"></script>
    <script src="../assets/js/books.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="../assets/js/ajaxFormVendite.js"></script>
    <script src="../assets/js/historyReplace.js"></script>
    <script>
    
    document.getElementById("hide-delete").addEventListener("click", notDisplayDelete);
    
    function displayDelete(el) {
        document.getElementById('libro-da-eliminare').value = el.toString();
        document.getElementById('delete-book').style.display = 'flex';
    }
    function notDisplayDelete() {
        document.getElementById('delete-book').style.display = 'none';
    }
    

    </script>
    

    <script>
    function showErrorSaldo() {
        document.getElementById('insufficiente').style.display = 'block';

    }
    </script>
    <?php 
    if (isset($_GET['res']) && ($_GET['res'] === 'spedito')) {
        echo "<script>document.getElementById('spedito').style.display = 'block';</script>";
    }
    if (isset($_GET['res']) && ($_GET['res'] === 'eliminato')) {
        echo "<script>document.getElementById('eliminato').style.display = 'block';</script>";
    }
    if (isset($_GET['res']) && ($_GET['res'] === 'errore')) {
        echo "<script>document.getElementById('errore').style.display = 'block';</script>";
    }
    if (isset($_GET['res']) && ($_GET['res'] === 'saldo')) {
        echo "<script>document.getElementById('saldo').style.display = 'block';</script>";
    }
    ?>
</body>

</html>

<?php

if (!isset($_SESSION['user_token'])) {
    session_destroy();
    header("Location: ../login/");
    die();
} else {
    //ELIMINAZIONE LIBRO 
    if (isset($_POST['elimina'])) {
        
        
        //verifichiamo che i parametri post siano presenti e corretti
        if (!isset($_POST['elimina']) || !isset($_POST['libro-eliminato'])
            || $_POST['elimina'] !== 'si' || intval($_POST['libro-eliminato']) === 0) {
            header('location: index.php');
            die();
        }
        
        $book_id = intval($_POST['libro-eliminato']);
        if ($user_id === 0) {
            header('location: ../login/');
            die();
        }
        
        //controllo che l'user loggato sia effettivamente il proprietario del libro
        $query = "SELECT * FROM `books` WHERE `id`= :book_id AND user_id = :user_id";
        
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() !== 1) {
            header('location: index.php');
            die();
        }
        
        //controllo che il libro non sia in un ordine non completato
        $query = "SELECT * FROM `orders` WHERE `book_id`= :book_id AND `seller_id` = :user_id AND `status` != 2";
        
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            header('location: index.php?res=errore');
            die();
        }
        
        //elimino ANCHE GLI AUTORI
        $query = "DELETE FROM `autori` WHERE `book_id`= :book_id";
        
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            header('location: index.php');
            die();
        }
        
        $query = "DELETE FROM `books` WHERE `id`= :book_id AND user_id = :user_id";
        
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(':book_id', $book_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            header('location: index.php');
            die();
        }
        removeDir($book_id);
        header('location: index.php?res=eliminato');
        die();
        
    }
            
    
    
    //NUOVO LIBRO
    
    if (isset($_POST['sell-submit'])) {
        $user_id = intval($_SESSION['session_user']);
        if ($user_id === 0) {
            header('location: ../index.php');
            die();
        }
        $titolo = clean_data($_POST['titolo']);
        $titolo = filter_var($titolo, FILTER_SANITIZE_STRING);
        
        $autori = clean_data($_POST['autore']);
        $autori = filter_var($autori, FILTER_SANITIZE_STRING);
        
        $prezzo = filter_var($_POST['prezzo'], FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        
        if (isset($_POST['isbn'])) {
            $isbn = clean_data($_POST['isbn']);
        } else {
            $isbn = "";
        }
        $condizioni = filter_var($_POST['condizioni'], FILTER_SANITIZE_NUMBER_INT);
        $book_uniqid = uniqid();
        
        $descrizione = clean_data($_POST['descrizione']);
        $descrizione = filter_var($descrizione, FILTER_SANITIZE_STRING);
        
        $foto = $_POST['foto'];
        $files = $_POST['files'];
        if (empty($condizioni)) {
            $condizioni = 5;
        }
        if (!$condizioni || $condizioni < 1 || $condizioni > 5) {
            echo '<script type="text/javascript">
                        alert("Alcuni campi non sono validi");
                        </script>';
            header('refresh: 0');
            die();
        }
        
        $allowType = array('jpg', 'png', 'jpeg', 'gif');
        $fileNames = array_filter($_FILES['files']['name']);
        $names = array();
        if (!empty($fileNames)) {
            foreach ($_FILES['files']['name'] as $key => $val) {
                $fileName = clean_data(basename($_FILES['files']['name'][$key]));
                array_push($names, $fileName);

                $targetFilePath = $targetDir . $fileName;

                // Check whether file type is valid
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                if (!in_array($fileType, $allowType)) {
                    echo "<script>alert('Tipologia file non ammessa');</script>";
                    header('refresh: 0');
                    die();
                }
            }
        }
                
                

        if (empty($titolo) || empty($prezzo) || empty($autori) || empty($condizioni) || strlen($descrizione) > 500) {
            echo '<script type="text/javascript">
                        alert("Alcuni campi non sono validi");
                        </script>';
            header('refresh: 0');
            die();
        }
        if (count($_FILES['files']['name']) > 3) {
            echo "<script>alert('Puoi caricare al massimo 3 files');</script>";
            header('refresh: 0');
            die();
        }
        

        if (empty($foto)) {
            $sql = "INSERT INTO `books` (`user_id`,`uniqid`,`title`,`autori`, `price`, `isbn`, `conditions`,`description`)
            VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id,
                $book_uniqid,
                $titolo,
                $autori,
                $prezzo,
                $isbn,
                $condizioni,
                $descrizione]);
        } else {

            $sql = "INSERT INTO `books` (`user_id`,`uniqid`,`image`, `title`,`autori`, `price`, `isbn`, `conditions`,`description`)
            VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id,
                $book_uniqid,
                $foto,
                $titolo,
                $autori,
                $prezzo,
                $isbn,
                $condizioni,
                $descrizione]);
        }

        //ora inserisco le immmagini caricate dall'utente

        $dbHost = "31.11.39.74";
        $dbUsername = "Sql1604984";
        $dbPassword = "restasincronizzatOpersempre190!@";
        $dbName = "Sql1604984_1";

        // Create database connection
        $con = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        $sql = "SELECT `id` FROM `books` WHERE `uniqid` = '$book_uniqid' AND `user_id` = '$user_id'";
        $result = $con->query($sql);
        $row = $result->fetch_assoc();
        $book_id = $row['id'];
        
        //inserisco gli autori
        $arrayAutori = explode(",", $autori);
        for ($i = 0;$i < count($arrayAutori);$i++) {
            $sqlAutori = "INSERT INTO `autori` (`book_id`,`nome`)
            VALUES (:book_id,:nome)";
            $stmtAutori = $pdo->prepare($sqlAutori);
            $stmtAutori->bindParam(":book_id",$book_id,PDO::PARAM_INT);
            $stmtAutori->bindParam(":nome",clean_data($arrayAutori[$i]),PDO::PARAM_STR);
            $stmtAutori->execute();
        }

        //fino a qui ok

        $targetDir = "../assets/img/uploads/";
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

        $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
        
        
        $fileNames = array_filter($_FILES['files']['name']);
        
        

        $names_to_insert = array();

        if (!empty($fileNames)) {
            foreach ($_FILES['files']['name'] as $key => $val) {
                // File upload path
                $fileName = clean_data(basename($_FILES['files']['name'][$key]));
                array_push($names_to_insert, $fileName);

                $targetFilePath = $targetDir . $fileName;

                // Check whether file type is valid
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                if (in_array($fileType, $allowTypes)) {
                    // Upload file to server
                    if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
                        // Image db insert sql
                        $insertValuesSQL .= "('" . $book_id . "','" . $fileName . "', NOW()),";
                    } else {
                        $errorUpload .= $_FILES['files']['name'][$key] . ' | ';
                    }
                } else {
                    $errorUploadType .= $_FILES['files']['name'][$key] . ' | ';
                }
            }

            // Error message
            $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . trim($errorUpload, ' | ') : '';
            $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . trim($errorUploadType, ' | ') : '';
            $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;

            if (!empty($insertValuesSQL)) {
                $insertValuesSQL = trim($insertValuesSQL, ',');
                // Insert image file name into database
                for ($i = 0, $size = count($names_to_insert); $i < $size; ++$i) {
                    $name_to_insert = $names_to_insert[$i];
                    $insert = $con->query("INSERT INTO images (book_id,file_name) VALUES ('$book_id','$name_to_insert')");
                }
                if ($insert) {
                    $statusMsg = "Files are uploaded successfully." . $errorMsg;

                    createDir($book_id);
                    $page = $_SERVER['PHP_SELF'];
                    $sec = "10";
                    header("location: ../books/$book_id/");
                    die();
                } else {
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            } else {
                $statusMsg = "Upload failed!";
            }
        } else {
            $statusMsg = 'Please select a file to upload.';
        }
        echo "<script>alert($statusMsg);</script>";

    }
    //FINE NUOVO LIBRO

    //RITIRO SALDO
    if (isset($_POST['get-saldo'])) {
        $passwordSaldo = clean_data($_POST['password-saldo']);
        $checkboxSaldo = clean_data($_POST['checkbox-saldo']);
        if (!$passwordSaldo || !$checkboxSaldo) {
            echo "<script>document.getElementById('obbligatori').style.display = 'block';</script>";
            echo "<script>document.getElementById('get-cash').style.display = 'flex';</script>";
            die(); //
        } else {
            if ($saldo < 15) {
                echo "<script>document.getElementById('insufficiente').style.display = 'block';</script>";
                echo "<script>document.getElementById('get-cash').style.display = 'flex';</script>";
                die(); //
            } else {
                $query = "
                SELECT *
                FROM users
                WHERE id = :user_id
            ";
                $check = $pdo->prepare($query);
                $check->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $check->execute();
                $user = $check->fetch(PDO::FETCH_ASSOC);
                if (!password_verify($passwordSaldo, $user['password'])) {
                    echo "<script>document.getElementById('errata').style.display = 'block';</script>";
                    echo "<script>document.getElementById('get-cash').style.display = 'flex';</script>";
                    die(); //
                }
                if ($user_id !== $user['id']) {
                    header("location: ../my_account/");
                    die();
                }
                if (!$user['name'] || strlen($user['name'] === 0) || !$user['surname'] || strlen($user['surname'] === 0)) {
                    echo "<script>document.getElementById('nome').style.display = 'block';</script>";
                    echo "<script>document.getElementById('get-cash').style.display = 'flex';</script>";
                    die(); //
                }
                if (!($user['iban']) || (strlen($user['iban']) !== 27)) {
                    echo "<script>document.getElementById('iban').style.display = 'block';</script>";
                    echo "<script>document.getElementById('get-cash').style.display = 'flex';</script>";
                    die(); //
                }
                $iban = clean_data($user['iban']);
                //aggiorno il saldo attuale dell'utente e poi invio la mail all'amministrazione
                //dove si dice che l'utente x ha richiesto il saldo
                echo 1;
                $sql = 'UPDATE saldo set lordo = 0 , netto = 0 , commissione = 0 , ricevuto = ricevuto + :netto where user_id = :id';
                $statement = $pdo->prepare($sql);
                $statement->bindParam(':netto', $saldo, PDO::PARAM_INT);
                $statement->bindParam(':id', $user_id, PDO::PARAM_INT);

                if (!$statement->execute()) {
                    echo "<script>document.getElementById('generico').style.display = 'block';</script>";
                    echo "<script>document.getElementById('get-cash').style.display = 'flex';</script>";
                    die(); //
                }
                //parte di invio mail
                sendMail($user_id,$saldo,$iban);
                header("location: index.php?res=saldo");
                die();

            }
        }
    }
    //FINE RITIRO SALDO
}


function createDir($id)
{
    $filename = "../books/" .$id. "/";
    mkdir($filename, 0700);
    if (!$fp = fopen("../books/" . $id . "/index.php", "w+")) {
        exit;
    }
    $testo = '<?php $book = ' . $id . '; require_once("../book.php"); ?>';

    if (fwrite($fp, $testo) === false) {
    exit;
    }
    fclose($fp);
}

function removeDir($id) {
    $dirname = "../books/" .$id. "/";
    array_map('unlink', glob("$dirname/*.*"));
    
    rmdir($dirname);
}

function sendMail($user,$user_saldo,$user_iban) {
    error_reporting(E_ALL);

    // Genera un boundary
    $mail_boundary = "=_NextPart_" . md5(uniqid(time()));
    
    $to = "angeleri.0206@gmail.com";
    $subject = "Saldo richiesto";
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
    $msg .= "Saldo richiesto. L'utente $user ha richiesto la riscossione del saldo per un importo pari a $user_saldo. Il suo IBAN è $user_iban. Esegui le verifiche prima dell' invio del denaro. ";  // aggiungi il messaggio in formato text
     
    $msg .= "\n--$mail_boundary\n";
    $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    $msg .= "Content-Transfer-Encoding: 8bit\n\n";
    $msg .= "<h2>Saldo richiesto</h2><p>L'utente <strong>$user</strong> ha richiesto la riscossione del saldo per un importo pari a <strong>$user_saldo</strong>. Il suo IBAN è <strong>$user_iban</strong>. Esegui le verifiche prima dell' invio del denaro.</p><br><p> Grazie, lo staff di BiblionTech</p>";   // aggiungi il messaggio in formato HTML
     
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