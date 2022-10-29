<?php
require_once('../includes/session.php');
require_once('../includes/functions.php');

if (isset($_GET['email'], $_GET['code'])) {
	if ($stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND activation_code = :code')) {

        $email = $_GET['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $code = $_GET['code'];
        $code = clean_data($code);
		$stmt->bindParam(':email', $email);
        $stmt->bindParam(':code', $code);
		if (!$stmt->execute()) {
            header('Location: ../acquista');
            die();
        }
		$numRows = $stmt->rowCount();
        if ($numRows === 0) {
            header('Location: ../acquista');
            die();
        }
        
			// Account exists with the requested email and code.
        if ($stmt = $pdo->prepare('UPDATE users SET activation_code = :newcode WHERE email = :email AND activation_code = :code')) {
            // Set the new activation code to 'activated', this is how we can check if the user has activated their account.
            $newcode = 'activated';
            
            $stmt->bindParam(':newcode', $newcode);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':code', $code);
            if (!$stmt->execute()) {
                header('Location: ../my_account');
                die();
            }
            $_SESSION['active'] = true;
            
            header('Location: ../my_account');
            die();
            
        }
    } else {
        header('Location: ../my_account');
        die();
    }
} else {
    header('Location: ../my_account');
    die();
}

?>