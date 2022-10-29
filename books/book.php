<?php 

require_once('../../includes/session.php');
require_once("../../includes/functions.php");
$query = "
SELECT * from books where id = :id
";

$check = $pdo->prepare($query);
$check->bindParam(':id', $book, PDO::PARAM_STR);
$check->execute();
$res = $check->fetchAll();


if ($check->rowCount() === 0) {
    header('location: ../../acquista/');
    die();
}

//prendo le informazioni del libro
$user_id = $res[0]['user_id'];
$image = $res[0]['image'];
$title = $res[0]['title'];
$autori = $res[0]['autori'];
$price = $res[0]['price'];
$isbn = $res[0]['isbn'];
$conditions = $res[0]['conditions'];
$description = $res[0]['description'];
$status = $res[0]['status'];

if ($status !== 0) {
    header('location: ../../acquista/');
    die();
}

$query = "
SELECT * from users where id = :id
";

$check = $pdo->prepare($query);
$check->bindParam(':id', $user_id, PDO::PARAM_STR);
$check->execute();
$res = $check->fetchAll();


if ($check->rowCount() === 0) {
    header('location: ../../acquista/');
    die();
}

$username = $res[0]['username'];

if (isset($_SESSION['user_token'])) {
    $logged = 1;
} else {
    $logged = 0;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
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
        .zoom {
            position: fixed;
            display: none;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
            top: 25%;
            left: 25%;
            width: 50%;
            height: 50%;
            z-index: 11;
            transition: ease all 2s;
        }
        .zoom-image {
            width: 100% !important;
            height: 100% !important;
            max-width: 80vw !important;
            max-height: 80vh !important;
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
                    </ul><a class="btn nav-btn click" type="button" href="https://bibliontech.it/login/" ><i
                        class="far fa-user"></i></a>
                    ';
                    

                } else {
                    echo '
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/acquisti/">Acquisti</a></li>
                    <li class="nav-item"><a class="nav-link" href="https://bibliontech.it/vendite/">Vendite</a></li>
                    ';
                    echo "
                    </ul><a href='https://bibliontech.it/login/logout.php?token=$user_token'>Logout</a><a href='https://bibliontech.it/login/' class='btn nav-btn click' type='button'>
                     style='color:white !important;'><i
                        class='far fa-user'></i></a>
                    ";
                }

                ?>


            </div>
        </div>
    </nav>
    <section class="home-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="books-container">
                        <div class="prod-box">
                            <div class="carousel slide carousel-dark" data-bs-ride="carousel" data-bs-interval="false"
                                data-bs-pause="false" data-bs-keyboard="false" id="carousel-1">
                                <div class="carousel-inner">

                                    <?php 

                                    $query = "
                                    SELECT * from images where book_id = :id
                                    ";

                                    $check = $pdo->prepare($query);
                                    $check->bindParam(':id', $book, PDO::PARAM_INT);
                                    $check->execute();
                                    $res = $check->fetchAll();
                                    $numImages = $check->rowCount();
                                    $copertina = $image;
                                    
                                    if ($image) {
                                        echo "
                                        
                                        <div class='carousel-item active'><img class='img-fluid d-block'
                                            src='$image'
                                            alt='Slide Image' name='slide-image' id='copertina'>
                                            </div>
                                            
                                        
                                            
                                            
                                            

                                        ";
                                        for ($i = 0;$i < $numImages;$i++) {
                                            $image = $res[$i]['file_name'];
                                                echo "
                                                <div class='carousel-item'><img class='img-fluid w-100 d-block'
                                                src='../../assets/img/uploads/$image' onclick='zoomImage($i)'
                                                alt='Slide Image' name='slide-image'></div>
                                                
                                                <!-- DIV PER ZOOM IMMAGINE -->
                                                <div  class='add-book' id='image$i' style='display:none;'>
                                                    <div>
                                                    <button class='btn btn-close shadow-none click' style='top: inherit; right: inherit;' onclick='zoomClose($i)'
                                            type='button'></button>
                                                        <img class='zoom-image'
                                                        src='../../assets/img/uploads/$image'
                                                        alt='Slide Image' >
                                                    </div>
                                                </div>
                                                <!--FINE DIV PER ZOOM IMMAGINE -->
                                                "; 
                                            
                                        }
                                    } else {
                                        
                                        for ($i = 0;$i < $numImages;$i++) {
                                            $image = $res[$i]['file_name'];
                                            if ($i === 0) {
                                                echo "
                                                <div class='carousel-item active'><img onclick='zoomImage($i)' class='img-fluid w-100 d-block'
                                                src='../../assets/img/uploads/$image'
                                                alt='Slide Image' name='slide-image'></div>
                                                
                                                <!-- DIV PER ZOOM IMMAGINE -->
                                                <div  class='add-book' id='image$i' style='display:none;'>
                                                    <div>
                                                    <button class='btn btn-close shadow-none click' style='top: inherit; right: inherit;' onclick='zoomClose($i)'
                                            type='button'></button>
                                                        <img class='zoom-image'
                                                        src='../../assets/img/uploads/$image'
                                                        alt='Slide Image' >
                                                    </div>
                                                </div>
                                                <!--FINE DIV PER ZOOM IMMAGINE -->
                                                ";
                                            } else {
                                                echo "
                                                <div class='carousel-item'><img onclick='zoomImage($i)' class='img-fluid w-100 d-block'
                                                src='../../assets/img/uploads/$image'
                                                alt='Slide Image' name='slide-image'></div>
                                                
                                                <!-- DIV PER ZOOM IMMAGINE -->
                                                <div  class='add-book' id='image$i' style='display:none;'>
                                                    <div>
                                                    <button class='btn btn-close shadow-none click' style='top: inherit; right: inherit;' onclick='zoomClose($i)'
                                            type='button'></button>
                                                        <img class='zoom-image'
                                                        src='../../assets/img/uploads/$image'
                                                        alt='Slide Image' >
                                                    </div>
                                                </div>
                                                <!--FINE DIV PER ZOOM IMMAGINE -->
                                                "; 
                                                
                                            }
                                        }
                                            
                                    }

                                    ?>

                                </div>


                                <div><a class="carousel-control-prev" href="#carousel-1" role="button"
                                        data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span
                                            class="visually-hidden">Previous</span></a><a class="carousel-control-next"
                                        href="#carousel-1" role="button" data-bs-slide="next"><span
                                            class="carousel-control-next-icon"></span><span
                                            class="visually-hidden">Next</span></a></div>
                                <ol class="carousel-indicators">
                                    <?php 
                                    if (!empty($copertina)) {
                                        $numImages = $numImages + 1;
                                    }
                                    for ($i = 0; $i < $numImages; $i++) {
                                        if ($i === 0) {
                                            echo "
                                            <li data-bs-target='#carousel-1' data-bs-slide-to='$i' class='active'></li>
                                            ";
                                        } else {
                                            echo "
                                            <li data-bs-target='#carousel-1' data-bs-slide-to='$i'></li>
                                            ";
                                        }
                                    }

                                    ?>
                                </ol>
                            </div>
                        </div>
                        <div class="prod-box">
                            <div>
                                <div class="bookP-info">
                                    <h2 class="bookP-title"><?php echo $title; ?></h2>

                                    <span class="bookP-author">di&nbsp;<?php
                                     echo getAutori($book);
                                     
                                     ?></span>


                                    <span class="bookP-seller">venduto
                                        da&nbsp;<a
                                            href="../../users/<?php echo $username;?>"><?php echo $username;?></a></span>

                                    <span>ISBN:&nbsp;<span><strong><?php echo $isbn;?></strong></span></span>


                                    <div class="book-rate">
                                        <br><label style='color:black'>Condizioni</label><br>
                                        <?php 
                                        
                                        for ($i = 0; $i < $conditions;$i++) {
                                            echo '
                                            <i class="fas fa-book"></i>
                                            ';
                                        }
                                        for ($i = 0; $i < 5 - $conditions;$i++) {
                                            echo '
                                            <i class="fas fa-book not-checked"></i>
                                            ';
                                        }

                                        ?>
                                    </div>
                                </div>
                                <div class="bookP-desc"><span>
                                        <?php echo $description; ?><br></span></div>
                                <div><span class="book-price"><strong>€&nbsp;</strong><?php echo $price; ?><br></span>
                                </div>
                                <div>
                                    <?php 
                                    require_once('../../includes/session.php');
                                    if (isset($_SESSION['user_token'])) {
                                        $buyer_id = intval($_SESSION['session_user']);
                                        if ($buyer_id === 0) {
                                            header('Location: ../../login');
                                            die();
                                        }

                                        if ($buyer_id === $user_id) {
                                            echo "
                                        
                                        <a href='../../login'><button class='btn form-button shadow-none click'
                                            type='button'>Acquista</button></a>

                                        ";
                                        } else {
                                            
                                        echo "
                                        <form method='post' action='../../site/public/create-checkout-session.php?b=$buyer_id&s=$user_id&id=$book&n=$title&p=$price'>
                                        <button class='btn form-button shadow-none click'
                                            type='submit' name='submit'>Acquista</button></form>

                                        ";
                                        }

                                    } else {
                                        echo "
                                        
                                        <a href='../../login/'><button class='btn form-button shadow-none click'
                                            type='button'>Acquista</button></a>

                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <?php require_once('../../includes/footer.php'); ?>
    <script>
       function zoomImage(i) {
           var id = 'image'+i.toString();
         
           document.getElementById(id).style.display = 'flex';
       }
       function zoomClose(i) {
           var id = 'image'+i.toString();
          
           document.getElementById(id).style.display = 'none';
       }
    </script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/form.js"></script>
    <script src="../../assets/js/review.js"></script>
    <script src="../../assets/js/rotatebook.js"></script>
    <script src="../../assets/js/sell.js"></script>
    <script src="../../assets/js/typewriter.js"></script>
    <script src="../../assets/js/historyReplace.js"></script>
</body>

</html>