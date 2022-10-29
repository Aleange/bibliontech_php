<?php
require_once('../includes/session.php');


if (!isset($_SESSION['user_token'])) {
    session_destroy();
    header("Location: ../login/");
    exit;
} else {
    require_once('../includes/functions.php');
    if ($_SESSION['active'] === false) {
        $active = false;
    } else {
        $active = true;
    }
    
    $user_id = intval($_SESSION['session_user']);
    if ($user_id === 0) {
        header("Location: ../login/");
        die();
    } else {
        $sql = 'SELECT username,name,surname,birthdate,email,iban,profile_image FROM users WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute([':id' => $user_id]);
        if ($statement->rowCount() === 0) {
            header("Location: ../login/");
            die();
        } else {
            $user = $statement->fetchAll(PDO::FETCH_ASSOC);
            $name = $user[0]['name'];
            $surname = $user[0]['surname'];
            $email = $user[0]['email'];
            $birthdate = $user[0]['birthdate'];
            $iban = $user[0]['iban'];
            $username = $user[0]['username'];
            $profile_image = $user[0]['profile_image'];

        }

        //prendo l'indirizzo
        $sql = 'SELECT * FROM address WHERE user_id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute([':id' => $user_id]);
        if ($statement->rowCount() === 0) {
            header("Location: https://bibliontech.it/login/");
            die();
        } else {
            $address = $statement->fetchAll(PDO::FETCH_ASSOC);
            $cap = $address[0]['cap'];
            if ($cap == 0) {
                $cap = "";
            }
            $indirizzo = $address[0]['indirizzo'];

        }
    }
}
$user_token = $_SESSION['user_token'];

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
    a.h1 {
        font-size: 30px;
        font-weight: bold;
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center"
                href="https://bibliontech.it/"><span>BiblionTech</span></a><button data-bs-toggle="collapse"
                class="navbar-toggler" data-bs-target="#navcol-1"><span class="navbar-toggler-icon"><svg
                        xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none">
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
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/vendite/">Vendite</a></li>
                </ul><a href="https://bibliontech.it/login/logout.php?token=<?php echo $user_token;?>">Logout</a>
                <button class="btn nav-btn click" type="button"><i class="far fa-user"></i></button>
            </div>
        </div>
    </nav>


    <section>
        <div class="container my-container">
            <div class="row">
                <div class="col">
                    <div class="form-text">
                        <h1 class="form-h1">Ciao&nbsp;<strong id="username"><a class="h1"
                                    href="https://bibliontech.it/users/<?php echo $username;?>"><?php echo $username;?></a></strong>!
                        </h1>
                        <?php 
                        if (!$active) {
                            echo "
                            <span style='color:red;'>Attiva il tuo account utilizzando la mail che ti abbiamo inviato</span>
                            ";
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-center">


                        <form action="index.php" method="POST" enctype="multipart/form-data" id="formConfirm"
                            onsubmit="return regConfirm()">
                            <span id="indirizzo-valido" style="color:red;display:none;">Indirizzo non valido</span>
                            <span id="nome-valido" style="color:red;display:none;">Nome/Cognome non valido</span>
                            <span id="success" style="color:green;display:none;">Dati aggiornati con successo</span>
                            <span>Informazioni personali</span><br>


                            <input id="name-reg" name="nome" class="form-control" type="text" placeholder="Nome" value="<?php 
                                    echo $name;
                                ?>">

                            <input class="form-control" name="cognome" id="cognome-reg" type="text"
                                placeholder="Cognome" value="<?php 
                                    echo $surname;
                                ?>">

                            <input class="form-control" type="date" name="birthdate" id="birthdate-reg"
                                value="<?php echo $birthdate;?>" required>

                            <input class="form-control" type="text" placeholder="Username" name="username"
                                id="username-reg" value="<?php echo $username;?>" required>

                            <input class="form-control" type="text" placeholder="Codice IBAN" value="<?php 
                                    echo $iban;
                                ?>" id="iban-reg" name="iban">

                            <span><br>Immagine profilo</span>
                            <input class="form-control" type="file" name="profile_image">


                            <span><br>Indirizzo</span>

                            <input class="form-control" type="text" placeholder="CAP" value="<?php 
                                echo $cap;
                                ?>" name="cap" id="cap-reg">

                            <input class="form-control" type="text" placeholder="Indirizzo"
                                value="<?php echo $indirizzo;?>" name="indirizzo" id="indirizzo-reg">

                            <div style="width: 100%;">
                                <div class="row">
                                    <div class="col">
                                        <div class="d-flex justify-content-center">
                                            <button class="btn round-btn shadow-none click" id="add-book-open"
                                                type="submit" name="elimina"
                                                onclick="return confirm('Sei sicuro di voler eliminare il tuo account? Così facendo perderai tutto il tuo saldo disponibile...');"
                                                style="background-color: #ff0f00;"><i class="fas fa-user-times"
                                                    style="margin-left: 22px;"></i></button>
                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="d-flex justify-content-center"><button
                                                class="btn round-btn shadow-none click" id="get-cash-open" type="submit"
                                                name="conferma"><i class="fas fa-user-check"
                                                    style="margin-left: 22px;"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
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
    <script src="../assets/js/confirmForm.js"></script>
    <script src="../assets/js/historyReplace.js"></script>
    <?php 
    
    if (isset($_GET['not'])) {
        if ($_GET['not'] == 'i') {
            echo "<script>document.getElementById('indirizzo-valido').style.display = 'flex';</script>";
            echo "<script>document.getElementById('cap-reg').classList.add('is-invalid');</script>";
            echo "<script>document.getElementById('indirizzo-reg').classList.add('is-invalid');</script>";
        } 
        if ($_GET['not'] == 'n') {
            echo "<script>document.getElementById('nome-valido').style.display = 'flex';</script>";
            echo "<script>document.getElementById('name-reg').classList.add('is-invalid');</script>";
            echo "<script>document.getElementById('cognome-reg').classList.add('is-invalid');</script>";
        } 
    }
    if (isset($_GET['res']) && $_GET['res'] === 'ok') {
        echo "<script>document.getElementById('success').style.display = 'flex';</script>";
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
    if (isset($_POST['conferma'])) {
        $nome = $_POST['nome'] ?? '';
        $cognome = $_POST['cognome'] ?? '';
        $birthdate = $_POST['birthdate'] ?? '';
        $new_username = $_POST['username'] ?? '';
        $iban = $_POST['iban'] ?? '';
        $cap = $_POST['cap'] ?? 0;
        $indirizzo = $_POST['indirizzo'] ?? '';


        if ($_FILES['profile_image']['name'] !== "") {
            
            $file = $_FILES['profile_image'];
            $fileName = basename(htmlspecialchars($_FILES['profile_image']['name']));
            $fileTmp = htmlspecialchars($_FILES['profile_image']['tmp_name']);
            $fileSize = $_FILES['profile_image']['size'];
            $filesError = $_FILES['profile_image']['error'];
            $fileType = $_FILES['profile_image']['type'];
            $fileExt = explode('.',$_FILES['profile_image']['name']);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg','jpeg','png');
            
            //controllo che l'immagine abbia un'estensione consentita e poi la carico
            if(in_array($fileActualExt,$allowed)){
                if($filesError ===  0){
                    if($fileSize < 10485760){ 
                        $fileDestination = '../assets/img/profile_images/'.$fileName;
                        move_uploaded_file($fileTmp,$fileDestination);
                    }else{
                        
                        echo "<script>alert('File troppo grande');</script>";
                        die();
                    }
                }else{
                    echo "<script>alert('Errore nel caricamento del file');</script>";
                    die();
                }
            }else{
                echo "<script>alert('Non puoi caricare questo tipo di file');</script>";
                die();
            }
        } else {
            $fileName = $profile_image;
        }
        
        
        //AGGIORNO/INSERISCO I VALORI
        
        if ($new_username !== $username) {
            $new_username = check_username($new_username,$username,$user_id);
            $query = "
            UPDATE users SET username = :username, name = :name, surname = :surname, profile_image = :profile_image,iban = :iban, birthdate = :birthdate WHERE
            id = :id
            ";
            $check = $pdo->prepare($query);
            $check->bindParam(':username', $new_username, PDO::PARAM_STR);
            $check->bindParam(':name', $nome, PDO::PARAM_STR);
            $check->bindParam(':surname', $cognome, PDO::PARAM_STR);
            $check->bindParam(':profile_image', $fileName, PDO::PARAM_STR);
            $check->bindParam(':iban', $iban, PDO::PARAM_STR);
            $check->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
            $check->bindParam(':id', $user_id, PDO::PARAM_INT);
            if ($check->execute()) {
                $query = "
                UPDATE address SET cap = :cap, indirizzo=:indirizzo WHERE
                user_id = :id
                ";
                $check = $pdo->prepare($query);
                $check->bindParam(':cap', $cap, PDO::PARAM_STR);
                $check->bindParam(':indirizzo', $indirizzo, PDO::PARAM_STR);
                $check->bindParam(':id', $user_id, PDO::PARAM_INT);
                if ($check->execute()) {
                    header("Location: index.php?res=ok");
                    die();
                } else {
                    echo "<script>alert('Qualcosa è andato storto')</script>";
                    die();
                }
            } else {
                echo "<script>alert('Qualcosa è andato storto!')</script>";
                die();
            }
        } 
        else {
            $query = "
            UPDATE users SET username = :username, name = :name, surname = :surname, profile_image = :profile_image, iban = :iban, birthdate = :birthdate WHERE
            id = :id
            ";
            $check = $pdo->prepare($query);
            $check->bindParam(':username', $new_username, PDO::PARAM_STR);
            $check->bindParam(':name', $nome, PDO::PARAM_STR);
            $check->bindParam(':surname', $cognome, PDO::PARAM_STR);
            $check->bindParam(':profile_image', $fileName, PDO::PARAM_STR);
            $check->bindParam(':iban', $iban, PDO::PARAM_STR);
            $check->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
            $check->bindParam(':id', $user_id, PDO::PARAM_INT);
            if ($check->execute()) {
                
                $query = "
                UPDATE address SET cap = :cap, indirizzo=:indirizzo WHERE
                user_id = :id
                ";
                $check = $pdo->prepare($query);
                $check->bindParam(':cap', $cap, PDO::PARAM_STR);
                $check->bindParam(':indirizzo', $indirizzo, PDO::PARAM_STR);
                $check->bindParam(':id', $user_id, PDO::PARAM_INT);
                if ($check->execute()) {
                    header("Location: index.php?res=ok");
                    die();
                } else {
                    echo "<script>alert('Qualcosa è andato storto')</script>";
                    die();
                }
            } else {
                echo "<script>alert('Qualcosa è andato storto!')</script>";
                die();
            }
            
        }
        

    }

    //eliminazione account
    if (isset($_POST['elimina'])) {
        //verifico se l'utente ha ordini in sospeso
        $sql = 'SELECT * FROM orders WHERE (seller_id = :id OR buyer_id = :buyer_id) AND status != 2';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":id",$user_id,PDO::PARAM_INT);
        $statement->bindParam(":buyer_id",$user_id,PDO::PARAM_INT);
        $statement->execute();
        if ($statement->rowCount() === 0) {
            
            //ELIMINO RECENSIONI
            $sql = 'DELETE FROM recensioni WHERE recensore = :recensore OR recensito = :recensito';
            $statement = $pdo->prepare($sql);
            $statement->bindParam(":recensore",$user_id,PDO::PARAM_INT);
            $statement->bindParam(":recensito",$user_id,PDO::PARAM_INT);
            if (!$statement->execute()) {
                echo '<script>alert("Abbiamo riscontrato un problema")</script>';
                die();
            }
            
            //elimino gli ordini
            $sql = 'DELETE FROM orders WHERE seller_id = :seller OR buyer_id = :buyer ';
            $statement = $pdo->prepare($sql);
            $statement->bindParam(":seller",$user_id,PDO::PARAM_INT);
            $statement->bindParam(":buyer",$user_id,PDO::PARAM_INT);
            if (!$statement->execute()) {
                echo '<script>alert("Abbiamo riscontrato un problema")</script>';
                die();
            }
                
           

            //elimino gli indirizzi
            $sql = 'DELETE FROM address WHERE user_id = :id';
            $statement = $pdo->prepare($sql);
            $statement->bindParam(":id",$user_id,PDO::PARAM_INT);
            if ($statement->execute()) {

                //elimino il saldo
                $sql = 'DELETE FROM saldo WHERE user_id = :id';
                $statement = $pdo->prepare($sql);
                $statement->bindParam(":id",$user_id,PDO::PARAM_INT);
                if ($statement->execute()) {

                    //elimino i libri
                    $sql = 'DELETE FROM books WHERE user_id = :id';
                    $statement = $pdo->prepare($sql);
                    $statement->bindParam(":id",$user_id,PDO::PARAM_INT);
                    if ($statement->execute()) {
                        //elimino l'user ed esco
                        $sql = 'DELETE FROM users WHERE id = :id';
                        $statement = $pdo->prepare($sql);
                        $statement->bindParam(":id",$user_id,PDO::PARAM_INT);
                        if ($statement->execute()) {
                            removeDir($username);
                            header('location: ../login/logout.php?token='.$_SESSION['user_token']);
                            die();
                        }
                    } else {
                        echo '<script>alert("Abbiamo riscontrato un problema")</script>';
                        die();
                    }

                } else {
                    echo '<script>alert("Abbiamo riscontrato un problema")</script>';
                    die();
                }


            } else {
                echo '<script>alert("Abbiamo riscontrato un problema")</script>';
                die();
            }

        } else {
            echo "<script>alert('Hai ordini in sospeso...')</script>";
            die();
        }
    }
}

function check_username($newUsername,$oldUsername,$userId) {
    global $pdo;
    $query = "
            SELECT * FROM users WHERE username = :username
            ";
    $check = $pdo->prepare($query);
    $check->bindParam(':username', $newUsername, PDO::PARAM_STR);
    $check->execute();
    $rows = $check->rowCount();
    if ($rows == 0) {
        return $newUsername;
    } else {
        //manda lo script per username non disponibile
        return $oldUsername;
    }
}

function removeDir($id) {
    $dirname = "../users/" .$id. "/";
    array_map('unlink', glob("$dirname/*.*"));
    
    rmdir($dirname);
}




?>