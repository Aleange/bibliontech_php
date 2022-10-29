<?php
require_once('../includes/functions.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    .first-div-admin {
        overflow: auto;
    }

    .table>thead {
        vertical-align: bottom;
        background-color: #0b0a07;
        color: #f0f9ff;
    }


    .table-responsive {
        overflow-x: auto;
        display: none;
        -webkit-overflow-scrolling: touch;
    }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BiblionTech</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/css/account.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/form.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/typewriter.css">
    <style>
    #delete {
        background-color: red !important;
        width: 25px !important;
        height: 25px !important;
    }

    .far {
        font-size: 15px !important;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center"
                href="https://bibliontech.it/"><span>BiblionTech</span></a><button class="navbar-toggler" data-bs-toggle="collapse"
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
            <div id="navcol-1" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="https://bibliontech.it/acquista/">Home</a></li>
                    
                </ul><a href='../my_account/' class="btn nav-btn click" type="button"><i
                        class="far fa-user"></i></a>
            </div>
        </div>
    </nav>
    <section>
        <div class='first-div-admin'>
            <div class="container">
                <div class="row" style="position: sticky;">
                    <div class="col">
                        <div class="d-flex justify-content-center"><button id="books"
                                class="btn round-btn shadow-none click" type="button"><i
                                    class="fas fa-book"></i></button></div>
                    </div>
                    <div class="col d-flex justify-content-center align-items-center"><button id="users"
                            class="btn round-btn shadow-none click" type="button"><i class="fas fa-users"></i></button>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-center"><button id="shipments"
                                class="btn round-btn shadow-none click" type="button"><i
                                    class="fas fa-shipping-fast"></i></button></div>
                    </div>
                    <div class="col">
                        <div class="d-flex justify-content-center"><button id="wallets"
                                class="btn round-btn shadow-none click" type="button"><i
                                    class="fas fa-wallet"></i></button></div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col" style="width: 100vw;">
                        <span style="color:red;display:none;" id="error">Impossibile completare l'operazione</span>
                        <span style="color:red;display:none;" id="ordini">Il libro è presente in ordini che vanno prima eliminati</span>
                        <span style="color:red;display:none;" id="23000">L'utente ha ordini e/o libri da eliminare prima di essere eliminato</span>
                        <span style="color:green;display:none;" id="success">Operazione completata con successo</span>
                        <div id="books-table" class="table-responsive">
                            <table class="table table-hover">
                                <caption class="text-center caption-top">Libri</caption>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID Venditore</th>
                                        <th>Prezzo</th>
                                        <th>Valutazione</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php getBooksTable(); ?>

                                </tbody>
                            </table>
                        </div>
                        <div id="users-table" class="table-responsive">
                            <table class="table table-hover">
                                <caption class="text-center caption-top">Utenti</caption>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Data di nascita</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tbody>
                                    <?php getUsersTable(); ?>

                                </tbody>
                                </tbody>
                            </table>
                        </div>
                        <div id="shipments-table" class="table-responsive">
                            <table class="table table-hover">
                                <caption class="text-center caption-top">Spedizioni</caption>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ID Venditore</th>
                                        <th>ID Acquirente</th>
                                        <th>ID Libro</th>
                                        <th>Data acquisto</th>
                                        <th>Prezzo</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php getOrdersTable(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="wallets-table" class="table-responsive">
                            <table class="table table-hover">
                                <caption class="text-center caption-top">Saldi</caption>
                                <thead>
                                    <tr>
                                        <th>ID User</th>
                                        <th>Lordo</th>
                                        <th>Netto</th>
                                        <th>Commissione</th>
                                        <th>Ricevuto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php getSaldiTable(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require_once('../includes/footer.php'); ?>

    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/admin.js"></script>
    <script src="../assets/js/form.js"></script>
    <script src="../assets/js/review.js"></script>
    <script src="../assets/js/sell.js"></script>
    <script src="../assets/js/typewriter.js"></script>
    <script src="../assets/js/historyReplace.js"></script>
    <?php

    if (isset($_GET['error'])) {
        echo "<script>document.getElementById('error').style.display = 'block';</script>";
    }
    if (isset($_GET['ordini'])) {
        echo "<script>document.getElementById('ordini').style.display = 'block';</script>";
    }
    if (isset($_GET['success'])) {
        echo "<script>document.getElementById('success').style.display = 'block';</script>";
    }
    if (isset($_GET['code']) && intval($_GET['code']) === 23000) {
        echo "<script>document.getElementById('23000').style.display = 'block';</script>";
    }
    if (isset($_GET['page'])) {
        echo "<script>";
        $page = clean_data($_GET['page']);
        if ($page === 'books') {
            echo '
            books.style.display = "flex";
            users.style.display = "none";
            shipments.style.display = "none";
            wallets.style.display = "none";
            ';
        }
        if ($page === 'user') {
            echo '
            books.style.display = "none";
            users.style.display = "flex";
            shipments.style.display = "none";
            wallets.style.display = "none";
            ';
        }
        if ($page === 'orders') {
            echo '
            books.style.display = "none";
            users.style.display = "none";
            shipments.style.display = "flex";
            wallets.style.display = "none";
            ';
        }
        echo "</script>";
    }

    ?>
</body>

</html>