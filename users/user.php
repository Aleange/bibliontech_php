<?php
require_once('../../includes/functions.php');
require_once('../../includes/session.php');
if (isset($_SESSION['user_token'])) {
    $user_id = intval($_SESSION['session_user']);
    $user_token = $_SESSION['user_token'];
    if ($user_id === 0) {
        header('location: ../../login');
        die();
    }
    $logged = 1;
    $usernameLoggato = clean_data($_SESSION['session_username']);
} else {
    $logged = 0;
}


$query21 = "
SELECT * from users where id = :id
";
$check21 = $pdo->prepare($query21);
$check21->bindParam(':id', $user, PDO::PARAM_STR);
$check21->execute();
$res = $check21->fetchAll();
$username = $res[0]['username'];
$profile_image = $res[0]['profile_image'];

if ($profile_image !== 'https://icon-library.com/images/default-user-icon/default-user-icon-8.jpg') {
    $profile_image = '../../assets/img/profile_images/'.$profile_image;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    #add-review {
        transition: 1s all;
    }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BiblionTech</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../../assets/css/account.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/form.css">
    <link rel="stylesheet" href="../../assets/css/home.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/typewriter.css">
    <style>
        div.user {
            width: 100%;
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
                    
                    <?php

                if ($logged === 0) {
                    echo '
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/services/">Come funziona</a></li>
                    </ul><a href="../../login" class="btn nav-btn click" type="button" ><i
                        class="far fa-user"></i></a>
                    ';
                } else {
                    echo '
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/acquisti/">Acquisti</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/vendite/">Vendite</a></li>
                    ';
                    echo "
                    </ul><a href='https://bibliontech.it/login/logout.php?token=$user_token'>Logout</a><a href='../login/' class='btn nav-btn click' type='button'>
                    <i class='far fa-user'></i></a>
                    ";
                }

                ?>


            </div>
        </div>
    </nav>
    <section>
        <div class="user">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div>
                            <div>
                                <h1><?php echo $username; ?></h1>
                            </div>
                            <div class="profile-picture"><img class="rounded-circle" src=<?php echo $profile_image ?>>
                            </div>
                            <div class="d-sm-flex align-items-sm-center seller-stats">
                                <div style="width: 100%;">
                                    <div class="d-sm-flex justify-content-sm-center align-items-sm-center"><span>media
                                            recensioni&nbsp;</span>
                                        <div class="star-rate" style="width: auto;">
                                            <?php getAverageRating($user); ?>
                                        </div>
                                    </div>
                                    <div class="d-sm-flex justify-content-sm-center align-items-sm-center"><span>libri
                                            in vendita&nbsp;</span><span><strong><?php getSellingBooksNumber($user); ?></strong></span>
                                        
                                    </div>
                                    
                                     <div class="d-sm-flex justify-content-sm-center align-items-sm-center">
                                            <span>libri
                                                venduti&nbsp;</span><span><strong><?php getSoldBooksNumber($user); ?></strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container reviews-container">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-center justify-content-sm-start section-title">
                            <h2>Libri in vendita</h2>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="scroll">
                                <?php getBooksOfUser($user); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container reviews-container">
                <div class="row">
                    <div class="col">
                        <div class="section-title">
                            <div style="width: 100%;">
                                <h2>Recensioni</h2>
                            </div>
                            <div class="d-lg-flex justify-content-lg-center">
                                <?php


                            if (isset($_SESSION['user_token']) && $username !== $usernameLoggato) {
                                echo '
                                
                            <button
                                    class="btn round-btn shadow-none click" id="add-review-open" type="button"
                                    style="margin: 0;"><i class="fas fa-pen"></i></button></div>
                        
                                ';
                            } else {
                                echo '
                                <button
                                    class="btn round-btn shadow-none click"  type="button"
                                    style="margin: 0;"><i class="fas fa-pen"></i></button></div>
                                ';
                            }

                            ?>
                            </div>
                            <div>
                                <?php getReviewsOfUser($user); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            
                            <div id="add-review" class="add-book">
                                <div class="small-form-container">
                                    <form onsubmit="checkReviewForm()" action="index.php" method="post">
                                        <button class="btn btn-close shadow-none click" id="add-review-close"
                                            type="button"></button>

                                        <h1>Aggiungi recensione</h1><span>Lascia una recensione al venditore</span>
                                        <span id="failed" style="color:red;display:none;">Non puoi scrivere una
                                            recensione a
                                            questo
                                            utente</span>
                                        <textarea id="recensione" class="form-control" required="true"
                                            placeholder="Recensione" maxlength="600" style="resize: none;margin: 10px;"
                                            name="testo"></textarea>
                                        <div class="d-sm-flex align-items-md-center"><span>Valutazione</span>
                                            <div class="rating-css">
                                                <div class="star-icon">
                                                    <input type="radio" name="valutazione" value="1" id="rating1">
                                                    <label for="rating1" class="fa fa-star"></label>
                                                    <input type="radio" name="valutazione" value="2" id="rating2">
                                                    <label for="rating2" class="fa fa-star"></label>
                                                    <input type="radio" name="valutazione" value="3" id="rating3">
                                                    <label for="rating3" class="fa fa-star"></label>
                                                    <input type="radio" name="valutazione" value="4" id="rating4">
                                                    <label for="rating4" class="fa fa-star"></label>
                                                    <input type="radio" name="valutazione" value="5" id="rating5">
                                                    <label for="rating5" class="fa fa-star"></label>
                                                </div>
                                            </div>
                                        </div><button class="btn form-button click shadow-none" id="next-btn-1"
                                            type="submit" name="pubblica">Pubblica</button>
                                    </form>
                                </div>
                            </div>
                            
                            
                            <div id="delete-review" class="add-book">
                                <div class="small-form-container">
                                    <form action="index.php" method="post">
                                        <button class="btn btn-close shadow-none click" onclick="closeDelete();" id="delete-review-close"
                                            type="button"></button>

                                        <h2>Sei sicuro di voler eliminare questa recensione?</h2>
                                        <div class="d-flex align-items-center">
                                            <button class="round-btn click shadow-none" id="no-confirm-delete" type="button" style="background: rgb(255,15,0);">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button class="round-btn click shadow-none" id="confirm-delete" name="delete" type="submit">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <?php require_once('../../includes/footer.php'); ?>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/form.js"></script>
    <script src="../../assets/js/review.js"></script>
    <script src="../../assets/js/rotatebook.js"></script>
    <script src="../../assets/js/sell.js"></script>
    <script src="../../assets/js/typewriter.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../../assets/js/historyReplace.js"></script>
    <script>
        function displayDeleteReview(x) {
            var id = x;
            document.getElementById("delete-review").style.display = "flex";
            document.getElementById("confirm-delete").value = id;
        }
        var object = document.getElementById("no-confirm-delete");
        object.addEventListener("click", function() {
            document.getElementById("delete-review").style.display = "none";
        });
        function closeDelete() {
            document.getElementById("delete-review").style.display = "none";
        }
        $("#recensione").keyup(function(){
            var input = $(this).val();
            if (input.length < 10 || input.length > 600) {
                $("#recensione").removeClass("is-valid");
                $("#recensione").addClass("is-invalid");
            } else {
                $("#recensione").removeClass("is-invalid");
                $("#recensione").addClass("is-valid");
            }
            
        });
    </script>    

</body>

</html>

<?php


if (isset($_POST['pubblica'])) {
    if (!isset($_SESSION['user_token'])) {
        header('Location: ../../login/');
        die();
    } else {
        $recensore = $_SESSION['session_user'];
        $recensore = intval($recensore);
        if ($recensore === 0) {
            header('Location: ../../login/');
            die();
        }

        $query5 = "
        SELECT * from orders where buyer_id = :recensore and seller_id = :recensito
        ";
        $check5 = $pdo->prepare($query5);
        $check5->bindParam(':recensore', $recensore, PDO::PARAM_INT);
        $check5->bindParam(':recensito', $user, PDO::PARAM_INT);
        $check5->execute();
        $res = $check5->rowCount();


        if ($res === 0) {
            echo "<script>document.getElementById('failed').style.display = 'block';</script>";
            echo "<script>document.getElementById('add-review').style.display = 'flex';</script>";
            die();
        } else {

            //controllo che non abbia già scritto una recensione
            $query5 = "
            SELECT * from recensioni where recensore = :recensore and recensito = :recensito
            ";
            $check5 = $pdo->prepare($query5);
            $check5->bindParam(':recensore', $recensore, PDO::PARAM_INT);
            $check5->bindParam(':recensito', $user, PDO::PARAM_INT);
            $check5->execute();
            $res = $check5->rowCount();
            if ($res !== 0) {
                echo "<script>document.getElementById('failed').style.display = 'block';</script>";
                echo "<script>document.getElementById('add-review').style.display = 'flex';</script>";
                die();
            } else {
                $testo = clean_data($_POST['testo']);
                if (!isset($_POST['valutazione'])) {
                    $valutazione = 5;
                } else {
                    $valutazione = intval($_POST['valutazione']);
                }

                if ($valutazione === 0 || $valutazione < 1 || $valutazione > 5 || empty($valutazione)) {
                    echo "<script>document.getElementById('rating$valutazione').classList.add('is-invalid');</script>";
                    die();
                }
                if (empty($testo) || strlen($testo) > 600 || strlen($testo) < 10) {
                    echo "<script>document.getElementById('recensione').classList.add('is-invalid');</script>";
                    echo "<script>document.getElementById('add-review').style.display = 'flex';</script>";
                    die();
                }
                $query5 = "
                INSERT INTO recensioni (recensore,recensito,testo,valutazione)
                VALUES (:recensore,:recensito,:testo,:valutazione)
                ";
                $check5 = $pdo->prepare($query5);
                $check5->bindParam(':recensore', $recensore, PDO::PARAM_INT);
                $check5->bindParam(':recensito', $user, PDO::PARAM_INT);
                $check5->bindParam(':testo', $testo, PDO::PARAM_STR);
                $check5->bindParam(':valutazione', $valutazione, PDO::PARAM_INT);

                if ($check5->execute()) {
                    header("Refresh:0");
                    die();
                } else {
                    die("Error occured");
                }
            }
        }
    }
}


//eliminazione recensione

if (isset($_POST['delete'])) {
    if (!isset($_SESSION['user_token'])) {
        header('Location: ../../login/');
        die();
    }
    $recensore = $_SESSION['session_user'];
    $recensore = intval($recensore);
    if ($recensore === 0) {
        header("Location: index.php");
        die();
    }

    $id_recensione = $_POST['delete'];
    $id_recensione = intval($id_recensione);
    if ($id_recensione === 0) {
        header("Location: index.php");
        die();
    }
    //controllo che l'utente loggato abbia scritto una recensione per l'utente in questione
    //e che abbia questo id

    $query5 = "
    SELECT * from recensioni where recensore = :recensore and recensito = :recensito and id = :id
    ";
    $check5 = $pdo->prepare($query5);
    $check5->bindParam(':recensore', $recensore, PDO::PARAM_INT);
    $check5->bindParam(':recensito', $user, PDO::PARAM_INT);
    $check5->bindParam(':id', $id_recensione, PDO::PARAM_INT);
    $check5->execute();
    $res = $check5->rowCount();
    if ($res !== 1) {
        header("Location: index.php");
        die();
    }
    //se è presente la elimino
    $query5 = "
    delete from recensioni where recensore = :recensore and recensito = :recensito and id = :id
    ";
    $check5 = $pdo->prepare($query5);
    $check5->bindParam(':recensore', $recensore, PDO::PARAM_INT);
    $check5->bindParam(':recensito', $user, PDO::PARAM_INT);
    $check5->bindParam(':id', $id_recensione, PDO::PARAM_INT);
    $check5->execute();
    header("refresh: 0");
    die();
}

?>