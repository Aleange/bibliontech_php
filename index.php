<?php 
require_once('includes/session.php');
if (!isset($_SESSION['user_token'])) {
    $user_id = 0;
} else {
    $user_token = $_SESSION['user_token'];
    $user_id = intval($_SESSION['session_user']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BiblionTech</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/account.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/typewriter.css">
    <link rel="stylesheet" href="assets/css/cookie.css">
    <style>
        
    </style>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center"
                href="javascript:void(0);"><span>BiblionTech</span></a><button data-bs-toggle="collapse" class="navbar-toggler"
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
                
                if ($user_id === 0) {

                    echo '
                    <li class="nav-item"><a class="nav-link" href="services/">Come funziona</a></li>
                    </ul><a class="btn nav-btn click" type="button" href="login/"><i
                        class="far fa-user"></i></a>
                    ';
                    

                } else {
                    echo '
                    <li class="nav-item"><a class="nav-link" href="acquisti/">Acquisti</a></li>
                    <li class="nav-item"><a class="nav-link" href="vendite/">Vendite</a></li>
                    ';
                    echo "
                    </ul><a href='login/logout.php?token=$user_token'>Logout</a><a class='btn nav-btn click' href='../login/' type='button'>
                    <i
                        class='far fa-user'></i></a>
                    ";
                }

                ?>


            </div>
        </div>
    </nav>
    <section>
        <div class="container flex-center">
            <div class="row">
                <div class="col">
                    <div>
                        <h1 class="gradient-text">Acquista libri usati.</h1><span class="typed-text"></span><span
                            class="cursor">&nbsp;</span>
                    </div>
                    <div><a class="btn btn-tpw shadow-none gradient-background click" role="button" href="acquista/">Inizia</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
       
    <?php require_once('includes/footer.php'); ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/form.js"></script>
    <script src="assets/js/review.js"></script>
    <script src="assets/js/rotatebook.js"></script>
    <script src="assets/js/sell.js"></script>
    <script src="assets/js/typewriter.js"></script>
    
    
        
    </script>
</body>

</html>