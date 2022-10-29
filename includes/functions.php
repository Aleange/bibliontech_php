<?php

require_once('db.php');

$options = array(
    'options' => array(
        'default' => 0, // value to return if the filter fails
    )
);

function clean_data($testo)
{
    $testo = trim($testo);
    $testo = htmlspecialchars($testo);
    return $testo;
}

function getAutori($book_id)
{
    global $pdo;
    $id = intval($book_id);
    if ($id === 0) {
        return "a";
    }
    $sql = "SELECT * FROM autori WHERE book_id = :book_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":book_id", $id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
        return "";
    }
    $rows = $stmt->fetchAll();
    $res = "";
    foreach ($rows as $autore) {
        $nome = $autore['nome'];
        $res.= "<a href='https://bibliontech.it/acquista/?autore=$nome'>$nome</a>, ";
    }
    $res = substr($res, 0, -2);
    return $res;
}

function getBooksBought($user_id)
{
    global $pdo;
    $sql = "SELECT * FROM orders WHERE buyer_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $num_libri = $stmt->rowCount();
        if ($num_libri > 0) {
            $res = $stmt->fetchAll();
            foreach ($res as $row) {
                $book_id = intval($row['book_id']);
                $seller_id = intval($row['seller_id']);
                if ($seller_id === 0 || $book_id === 0) {
                    header("Location: ../login/");
                    die();
                }
                $created_at = $row['created_at'];
                $status = $row['status'];

                $sql1 = "SELECT * FROM books WHERE id = :id";
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->bindParam(':id', $book_id, PDO::PARAM_INT);
                $stmt1->execute();
                $result = $stmt1->fetchAll();
                $image = $result[0]['image'];
                if (strlen($image) < 2) {
                    $image = getFirstBookImage($book_id);
                }
                $title = $result[0]['title'];
                $price = $result[0]['price'];
                $autori = $result[0]['autori'];
                if ($status === 0) {
                    $status = 'non spedito';
                } elseif ($status === 1) {
                    $status = 'spedito';
                } elseif ($status === 2) {
                    $status = 'consegnato';
                }

                $sql2 = "SELECT * FROM users WHERE id = :id";
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->bindParam(':id', $seller_id, PDO::PARAM_INT);
                $stmt2->execute();
                $result1 = $stmt2->fetchAll();
                $seller_username = $result1[0]['username'];

                $autori = getAutori($book_id);

                echo "
                
                <div class='book sold'>
                <div class='d-md-flex justify-content-md-center book-img'><a href='#'><img
                            src='$image'></a>
                </div>
                <div class='book-info'>
                    <div><a class='book-title' href='../books/$book_id'>$title</a>
                    </div><span class='book-author'>di&nbsp;$autori</span>
                    <div><span class='book-price'><strong>€&nbsp;</strong>$price<br></span></div>
                </div>
                <div class='sold-details'>
                    <div><span>libro acquistato da <a href='../users/$seller_username/'>$seller_username</a>&nbsp;in
                            data&nbsp;<span>$created_at</span><br><br>stato:&nbsp;<span
                                style='font-weight: bold;'>$status</span></span>";

                if ($status === 'spedito') {
                    echo "
                        <div class='d-flex justify-content-center' style='width: 100%;'>

                            <form class='spedizione' action='consegnato.php' method='POST'>
                                <input hidden name='consegnato' type='number' value='$book_id'>
                                <input hidden name='seller' type='number' value='$seller_id'>
                                <button class='btn round-btn click shadow-none' type='submit' name='consegna'>
                                    <i class='fas fa-truck'></i>
                                </button>
                            </form>
                            
                        </div>";
                } elseif ($status === 'non spedito') {
                    echo "
                        <div class='d-flex justify-content-center' style='width: 100%;'>
                                <button class='btn round-btn click shadow-none'>
                                    <i class='fas fa-truck'></i>
                                </button>
                        </div>";
                } elseif ($status === 'consegnato') {
                    echo "
                        <div class='d-flex justify-content-center' style='width: 100%;'>
                                <button class='btn round-btn click shadow-none'>
                                    <i class='fas fa-check-double'></i>
                                </button>
                        </div>";
                }


                echo "   
                    </div>
                </div>
            </div>

                ";
            }
        }
    }
}

function getBooksSold($user_id)
{
    global $pdo;
    $sql = "SELECT * FROM books WHERE user_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $num_libri = $stmt->rowCount();
        if ($num_libri === 0) {
            echo "<script>document.getElementById('add-book1').style.display = 'flex';</script>";
        } else {
            $res = $stmt->fetchAll();
            foreach ($res as $row) {
                $id = $row['id'];
                //prendo lo stato spedizione del libro
                $sql1 = "SELECT * FROM orders WHERE book_id = :id";
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
                $statusSpedizione = 0;
                $ordinato = false;
                if ($stmt1->execute()) {
                    if ($stmt1->rowCount() === 1) {
                        $ordinato = true;
                        $rowSpedizione = $stmt1->fetchAll();
                        $statusSpedizione = $rowSpedizione[0]['status'];
                        $buyer_id = $rowSpedizione[0]['buyer_id'];
                        $sold_at = $rowSpedizione[0]['created_at'];

                        $sqlSeller = "SELECT * FROM users WHERE id = :id";
                        $stmtSeller = $pdo->prepare($sqlSeller);
                        $stmtSeller -> bindParam(":id", $buyer_id, PDO::PARAM_STR);
                        $stmtSeller->execute();
                        $rowsSeller = $stmtSeller->fetchAll();
                        $buyer = $rowsSeller[0]['username'];
                    } else {
                        $statusSpedizione = 0;
                    }
                }

                $image = $row['image'];
                if (strlen($image) < 2) {
                    $image = getFirstBookImage($id);
                }
                $title = $row['title'];
                $price = $row['price'];
                $isbn = $row['isbn'];
                $conditions = $row['conditions'];
                $status = $row['status'];
                $autori = $row['autori'];
                $autori = getAutori($id);
                if ($statusSpedizione === 0) {
                    $stat = 'non spedito';
                } elseif ($statusSpedizione === 1) {
                    $stat = 'spedito';
                } elseif ($statusSpedizione === 2) {
                    $stat = 'consegnato';
                }
                if ($status === 0) {
                    $class = "book";
                } else {
                    $class = "book sold";
                }
                echo "
                
                    <div class='$class'>
                        <div class='d-md-flex justify-content-md-center book-img'>
                            <a href='../books/$id/'><img src=$image></a>
                        </div>
                        <div class='book-info'>
                            <div>
                                <a class='book-title' href='../books/$id/'>$title</a>
                                <span class='book-author'>di&nbsp;$autori</span>
                            </div>
                            <div>
                                <span class='book-price'><strong>€&nbsp;</strong>$price<br></span>
                            </div>
                        </div>
                        <button class='btn btn-close shadow-none click' id='button-delete' onclick='displayDelete($id);' type='button'></button>";

                if ($ordinato) {
                    echo "<div class='sold-details'>
                            <div>
                                <span>libro venduto a&nbsp;<a href='https://bibliontech.it/users/$buyer'>$buyer</a>&nbsp;in data&nbsp;<span>$sold_at</span><br></span>
                                <br>
                                <span style='font-weight: bold;'>$stat</span><br>
                                <div class='d-flex justify-content-center' style='width: 100%;'>
                                ";
                    if ($statusSpedizione === 2) {
                        echo "<button class='btn round-btn click shadow-none' type='button'>
                                        <i class='fas fa-check-double'></i>
                                        </button>";
                    } else {
                        echo "<form class='spedizione' action='spedito.php' method='post'>
                                    <input hidden='true' name='spedito' value='$id' type='number'>
                                    <button class='btn round-btn click shadow-none' type='submit' name='spedisci'>
                                        <i class='fas fa-truck'></i></button>
                                        </form>";
                    }
                    echo "
                                    
                                </div>
                            </div>
                        </div>
                    </div>";
                } else {
                    echo "</div>";
                }
            }
        }
    }
}

function getTotalPages($per_page)
{
    global $pdo;
    $sql = "SELECT * FROM books WHERE status = 0";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        $num_libri = $stmt->rowCount();
        $total_records = $num_libri;
        $total_pages = ceil($total_records / $per_page);
    }
    return $total_pages;
}

function getTotalRecords()
{
    global $pdo;
    $sql = "SELECT * FROM books WHERE status = 0";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        $num_libri = $stmt->rowCount();
    }
    return $num_libri;
}

function getBooks($start_from)
{
    global $pdo;
    $sql = "SELECT * FROM books WHERE status = 0 LIMIT $start_from,20";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        $num_libri = $stmt->rowCount();
        $total_records = $num_libri;
        if ($num_libri === 0) {
            echo "<h3>Ancora nessun libro in vendita</h3>";

            $num_total_books = 0;
        } else {
            $res = $stmt->fetchAll();
            foreach ($res as $row) {
                $id = $row['id'];
                $image = $row['image'];
                $s = $row['user_id'];
                if (strlen($image) < 2) {
                    $image = getFirstBookImage1($id);
                }
                $title = $row['title'];
                $price = $row['price'];
                $isbn = $row['isbn'];
                $conditions = $row['conditions'];
                $status = $row['status'];
                $autori = $row['autori'];
                $autori = getAutori($id);

                echo "
                <div class='book'>
    <div class='d-md-flex justify-content-md-center book-img'><a href='../books/$id/'><img src=$image /></a></div>
    <div class='book-info'>
        <div><a class='book-title' href='../books/$id/'>$title</a><span class='book-author'>di $autori</span></div>
        <div><span class='book-price'><strong>€</strong>$price<br /></span></div>
    </div>
    </div>
                    ";
            }
        }
    }
}

function getBooksOfUser($user)
{
    global $pdo;

    $sql = "SELECT * FROM books WHERE status = 0 AND user_id = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $res = $stmt->fetchAll();
        foreach ($res as $row) {
            $id = $row['id'];
            $image = $row['image'];
            $s = $row['user_id'];
            if (strlen($image) < 2) {
                $image = getFirstBookImage2($id);
            }
            $title = $row['title'];
            $price = $row['price'];
            $isbn = $row['isbn'];
            $conditions = $row['conditions'];
            $status = $row['status'];
            $autori = $row['autori'];
            $autori = getAutori($id);

            echo "
                <div class='book'>
                                    <div class='book-img'><a href='../../books/$id/'><img
                                                src='$image'></a>
                                    </div>
                                    <div class='book-info'>
                                        <div><a class='book-title' href='../../books/$id/'>$title</a>
                                        <span class='book-author'>di&nbsp;$autori</span></div>
                                        <div><span class='book-price'><strong>€&nbsp;</strong>$price<br></span></div>
                                    </div>
                                </div>";
        }
    }
}

function getSellingBooksNumber($user)
{
    global $pdo;

    $sql = "SELECT * FROM books WHERE status = 0 AND user_id = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $res = $stmt->fetchAll();
        echo sizeof($res);
    } else {
        return 0;
    }
}

function getSoldBooksNumber($user)
{
    global $pdo;

    $sql = "SELECT * FROM orders WHERE seller_id = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $res = $stmt->fetchAll();
        echo sizeof($res);
    } else {
        return 0;
    }
}

function getReviewsOfUser($user)
{
    global $pdo;
    if (isset($_SESSION['user_token'])) {
        $loggato_id = intval($_SESSION['session_user']);
    }
    $sql = "SELECT * FROM recensioni WHERE recensito = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    $i = 1;
    if ($stmt->execute()) {
        $res = $stmt->fetchAll();
        foreach ($res as $row) {
            $id_recensione = intval($row['id']);
            $id_recensore = intval($row['recensore']);
            if ($id_recensore === 0) {
                return;
            }
            if ($id_recensore === $loggato_id) {
                $same = true;
            }
            $testo = clean_data($row['testo']);
            $valutazione = intval($row['valutazione']);
            if ($valutazione === 0) {
                return;
            }
            $sql1 = "SELECT * FROM users WHERE id = :user";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->bindParam(':user', $id_recensore, PDO::PARAM_INT);
            $stmt1->execute();
            $res1 = $stmt1->fetchAll();
            $username = $res1[0]['username'];
            $profile_image = $res1[0]['profile_image'];
            if (substr($profile_image, 0, 4) !== 'http') {
                $profile_image = '../../assets/img/profile_images/'.$profile_image;
            }

            echo "
            
            <div class='review'>";
            if (isset($same) && $same === true) {
                echo "<button class='btn btn-close shadow-none click' type='button' onclick='displayDeleteReview($id_recensione);'></button>";
            }
            echo "<div class='d-flex justify-content-center reviewer-info'>
                                    <div class='d-sm-flex align-items-sm-center' style='width: 100%;'>
                                        <div class='d-flex justify-content-center align-items-center'><img
                                                class='rounded-circle'
                                                src='$profile_image'>
                                            <a href='https://bibliontech.it/users/$username'><h1>$username</h1></a>
                                        </div>
                                        <div class='d-flex justify-content-center justify-content-sm-end star-rate'>";

            for ($i = 0; $i < $valutazione;$i++) {
                echo '
                                            <i class="fas fa-star"></i>
                                            ';
            }
            for ($i = 0; $i < 5 - $valutazione;$i++) {
                echo '
                                            <i class="fas fa-star not-checked"></i>
                                            ';
            }


            echo "             </div>
                                    </div>
                                </div>
                                <div class='review-content' id='$i'>
                                <span id='content$i'>
                                        $testo<br><br>
                                    </span>
                                </div>
                                <span id='readmore$i' onclick='readMore($i,divHeight$i);'>Leggi tutto</span>
                                <span id='readless$i' style='display:none' onclick='readLess($i);'>Leggi meno</span>
                            </div>
                            <script>
                                var divHeight$i = document.getElementById('content$i').offsetHeight;
                                if (divHeight$i < 118) {
                                    document.getElementById('readmore$i').style.display = 'none';
                                }
                            </script>
                            


            
            
            ";
        }
    }
}

function getAverageRating($user)
{
    global $pdo;
    $sql = "SELECT avg(valutazione) as valutazione FROM recensioni WHERE recensito = :user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $numRows = $stmt->rowCount();
        if ($numRows > 0) {
            $rows = $stmt->fetchAll();
            $valutazione = $rows[0]['valutazione'];
            if (intval($valutazione) === 0) {
                echo "n.d.";
                return;
            }
            $intvalutazione = intval($valutazione);
            if ($intvalutazione === 0) {
                return;
            }
            $decimalvalutazione = $valutazione - $intvalutazione;
            if ($decimalvalutazione > 0.2 && $decimalvalutazione < 0.8) {
                for ($i = 1; $i < $valutazione;$i++) {
                    echo '
                    <i class="fas fa-star"></i>
                    ';
                }
                echo '<i class="fas fa-star-half"></i>';
                for ($i = 1; $i < 5 - $valutazione;$i++) {
                    echo '
                    <i class="fas fa-star not-checked"></i>
                    ';
                }
            } else {
                for ($i = 0; $i < $valutazione;$i++) {
                    echo '
                    <i class="fas fa-star"></i>
                    ';
                }
                for ($i = 0; $i < 5 - $valutazione;$i++) {
                    echo '
                    <i class="fas fa-star not-checked"></i>
                    ';
                }
            }
        }
    }
}




function getFirstBookImage($book_id)
{
    $options = array(
        'options' => array(
            'default' => 0, // value to return if the filter fails
        )
    );
    $id = intval($book_id);
    $id = filter_var($id, FILTER_VALIDATE_INT, $options);
    if ($id === 0) {
        return "";
    } else {
        global $pdo;
        $sql = "SELECT * FROM images WHERE book_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rows = $stmt->fetchAll();
            $image = $rows[0]['file_name'];
            $src = "../assets/img/uploads/".$image;
            return $src;
        } else {
            return "";
        }
    }
    return "";
}

function getFirstBookImage1($book_id)
{
    global $pdo;
    $id = intval($book_id);
    $options = array(
        'options' => array(
            'default' => 0, // value to return if the filter fails
        )
    );
    $id = filter_var($id, FILTER_VALIDATE_INT, $options);
    if ($id === 0) {
        return "";
    } else {
        $sql = "SELECT * FROM images WHERE book_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rows = $stmt->fetchAll();
            $image = $rows[0]['file_name'];
            $src = "../assets/img/uploads/".$image;
            return $src;
        } else {
            return "/";
        }
    }
    return "/";
}

function getFirstBookImage2($book_id)
{
    global $pdo;
    $id = intval($book_id);
    $options = array(
        'options' => array(
            'default' => 0, // value to return if the filter fails
        )
    );
    $id = filter_var($id, FILTER_VALIDATE_INT, $options);
    if ($id === 0) {
        return "";
    } else {
        $sql = "SELECT * FROM images WHERE book_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rows = $stmt->fetchAll();
            $image = $rows[0]['file_name'];
            $src = "../../assets/img/uploads/".$image;
            return $src;
        } else {
            return "/";
        }
    }
    return "/a";
}

function getBooksTable()
{
    global $pdo;
    $sql = "SELECT * FROM books";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute()) {
        header("Location: ../index.php");
        die();
    }
    $res = $stmt->fetchAll();
    foreach ($res as $row) {
        $id = intval($row['id']);
        if ($id === 0) {
            header("Location: ../index.php");
            die();
        }
        $user_id = intval($row['user_id']);
        if ($user_id === 0) {
            header("Location: ../index.php");
            die();
        }
        $price = intval($row['price']);
        if ($price === 0) {
            header("Location: ../index.php");
            die();
        }
        $valutazione = intval($row['conditions']);
        if ($valutazione === 0) {
            header("Location: ../index.php");
            die();
        }
        $status = intval($row['status']);
        if ($status !== 0 && $status !== 1 && $status !== 2) {
            header("Location: ../index.php");
            die();
        }
        if ($status === 0) {
            $status = 'non venduto';
        } else {
            $status = 'venduto';
        }

        echo "
        <form class='spedizione' action='delete.php' method='post'>
    <tr>
        <td>$id</td>
        <td>$user_id</td>
        <td>$price</td>
        <td>$valutazione</td>
        <td>$status</td>
        <td>
            
            <button id='delete' class='btn round-btn click shadow-none' type='submit' name='book' value='$id' >
                <i class='far fa-trash-alt'></i>
            </button>
        
        </td>
    </tr>
    </form>";
    }
}

function getUsersTable()
{
    global $pdo;
    $sql = "SELECT * FROM users";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute()) {
        header("Location: ../index.php");
        die();
    }
    $res = $stmt->fetchAll();
    foreach ($res as $row) {
        $id = intval($row['id']);
        if ($id === 0) {
            header("Location: ../index.php");
            die();
        }
        $nome = clean_data($row['name']." ".$row['surname']);
        $username = clean_data($row['username']);
        if (!$username) {
            header("Location: ../index.php");
            die();
        }
        $email = clean_data($row['email']);
        if (!$email) {
            header("Location: ../index.php");
            die();
        }
        $birthdate = clean_data($row['birthdate']);
        if (!$birthdate) {
            header("Location: ../index.php");
            die();
        }
        $status = intval($row['status']);
        if ($status !== 0 && $status !== 1 && $status !== 2) {
            header("Location: ../index.php");
            die();
        }

        echo "
        <form class='spedizione' action='delete.php' method='post'>
    <tr>
        <td>$id</td>
        <td>$nome</td>
        <td>$username</td>
        <td>$email</td>
        <td>$birthdate</td>
        <td>
        
            <button id='delete' class='btn round-btn click shadow-none'type='submit' name='user' value='$id'>
                <i class='far fa-trash-alt'></i>
            </button>
        
        </td>
    </tr>
    </form>";
    }
}


function getOrdersTable()
{
    global $pdo;
    $sql = "SELECT * FROM orders";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute()) {
        header("Location: ../index.php");
        die();
    }
    $res = $stmt->fetchAll();
    foreach ($res as $row) {
        $id = clean_data($row['id']);
        if (!$id) {
            header("Location: ../index.php");
            die();
        }
        $venditore = intval($row['seller_id']);
        if ($venditore === 0) {
            header("Location: ../index.php");
            die();
        }
        $acquirente = intval($row['buyer_id']);
        if ($acquirente === 0) {
            header("Location: ../index.php");
            die();
        }
        $prezzo = intval($row['price']);
        if ($prezzo === 0) {
            header("Location: ../index.php");
            die();
        }
        $libro = intval($row['book_id']);
        if ($libro === 0) {
            header("Location: ../index.php");
            die();
        }
        $date = clean_data($row['created_at']);
        if (!$date) {
            header("Location: ../index.php");
            die();
        }
        $status = intval($row['status']);
        if ($status !== 0 && $status !== 1 && $status !== 2) {
            header("Location: ../index.php");
            die();
        }
        if ($status === 0) {
            $status = "non spedito";
        } elseif ($status === 1) {
            $status = "spedito";
        } else {
            $status = "consegnato";
        }

        echo "
        <form class='spedizione' action='delete.php' method='post'>
    <tr>
        <td>$id</td>
        <td>$venditore</td>
        <td>$acquirente</td>
        <td>$libro</td>
        <td>$date</td>
        <td>$prezzo</td>
        <td>$status</td>
        <td>
        
            <input hidden name='status' value='$status'>
            <button id='delete' class='btn round-btn click shadow-none' type='submit' name='order' value='$id'>
                <i class='far fa-trash-alt'></i>
            </button>
        
        </td>
    </tr>
    </form>";
    }
}

function getSaldiTable()
{
    global $pdo;
    $sql = "SELECT * FROM saldo";
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute()) {
        header("Location: ../index.php");
        die();
    }
    $res = $stmt->fetchAll();
    foreach ($res as $row) {
        $user = intval($row['user_id']);
        if ($user === 0) {
            header("Location: ../index.php");
            die();
        }
        $lordo = $row['lordo'];
        if (!$lordo) {
            header("Location: ../index.php");
            die();
        }
        $netto = $row['netto'];
        if (!$netto) {
            header("Location: ../index.php");
            die();
        }
        $commissione = $row['commissione'];
        if (!$commissione) {
            header("Location: ../index.php");
            die();
        }
        $ricevuto = $row['ricevuto'];
        if (!$ricevuto) {
            header("Location: ../index.php");
            die();
        }

        echo "
        <form class='spedizione' action='delete.php' method='post'>
    <tr>
        <td>$user</td>
        <td>$lordo</td>
        <td>$netto</td>
        <td>$commissione</td>
        <td>$ricevuto</td>
    </tr>
    </form>";
    }
}
