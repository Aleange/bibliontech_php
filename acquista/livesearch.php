<?php 

include('../includes/db.php');
include('../includes/functions.php');

if (isset($_POST['input'])) {
    $input = htmlspecialchars(trim($_POST['input']));
    
    $sql = "SELECT * FROM books WHERE status = 0 AND (title LIKE '{$input}%' OR autori LIKE '{$input}%' OR isbn LIKE '{$input}%')";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
        $num_libri = $stmt->rowCount();
        if ($num_libri === 0) {
            echo "<h3>La ricerca non ha prodotto risultati</h3>";
        } else {
            $res = $stmt->fetchAll();
            foreach ($res as $row) {
                $id = $row['id'];
                $image = $row['image'];
                $s = $row['user_id'];
                if (!$image) {
                    $image = getFirstBookImage1($id);
                }
                $title = $row['title'];
                $price = $row['price'];
                $isbn = $row['isbn'];
                $conditions = $row['conditions'];
                $status = $row['status'];
                $autori = getAutori($id);
                echo "                <div class='book'>
    <div class='d-md-flex justify-content-md-center book-img'><a href='../books/$id'><img src=$image /></a></div>
    <div class='book-info'>
        <div><a class='book-title' href='../books/$id'>$title</a><span class='book-author'>di $autori</span></div>
        <div><span class='book-price'><strong>€ </strong>$price<br /></span></div>
    </div>
</div>
                ";
                }
                
            }
        }
    }
    
    if (isset($_POST['autore'])) {
    $autore = clean_data($_POST['autore']);
    $sql = "SELECT  DISTINCT book_id FROM autori WHERE nome = :autore";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":autore",$autore,PDO::PARAM_STR);
    if ($stmt->execute()) {
        $num_libri = $stmt->rowCount();
        if ($num_libri === 0) {
            echo "<h3>La ricerca non ha prodotto risultati</h3>";
        } else {
            $res = $stmt->fetchAll();
            foreach ($res as $row) {
                $id = $row['book_id'];
                
                $sql1 = "SELECT * FROM books WHERE id = :id AND status = 0";
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt1->execute();
                $rowCount = $stmt1->rowCount();
                if ($rowCount === 0) {
                    echo "<h3>La ricerca non ha prodotto risultati</h3>";
                    die();
                }
                $row1 = $stmt1->fetch();
                $image = $row1['image'];
                $s = $row1['user_id'];
                if (!$image) {
                    $image = getFirstBookImage1($id);
                }
                $title = $row1['title'];
                $price = $row1['price'];
                $isbn = $row1['isbn'];
                $conditions = $row1['conditions'];
                $status = $row1['status'];
                $autori = getAutori($id);
                echo "                <div class='book'>
    <div class='d-md-flex justify-content-md-center book-img'><a href='../books/$id'><img src=$image /></a></div>
    <div class='book-info'>
        <div><a class='book-title' href='../books/$id'>$title</a><span class='book-author'>di $autori</span></div>
        <div><span class='book-price'><strong>€ </strong>$price<br /></span></div>
    </div>
</div>
                ";
                }
                
            }
        }
    }


?>