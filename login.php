<?php
session_start();

if (isset($_SESSION['logedin']) && $_SESSION['logedin'] == 'yes') {
    header('location: view.php');
    return;
}


if (isset($_POST['cancel'])) {
    header('location: index.php');
    return;
} elseif (isset($_POST['submit'])) {
    if (!isset($_POST['email']) || strlen($_POST['email']) < 1) {
        $_SESSION['msg'] = '<p style="color:red;"> Email is required!</p>';
        header('location: login.php');
        return;
    } elseif (!preg_match('/^[a-zA-Z0-9_\.]+\@([a-zA-Z0-9_]+\.)+[a-zA-Z0-9]+$/', $_POST['email'])) {
        $_SESSION['msg'] = '<p style="color:red;"> Email is incorrect!</p>';
        header('location: login.php');
        return;
    } elseif (!isset($_POST['pass']) || strlen($_POST['pass']) < 1) {
        $_SESSION['msg'] = '<p style="color:red;"> Password is required!</p>';
        header('location: login.php');
        return;
    } else {
        //email is ok. password is entered. checking password
        $salt = "Ag_$3s7";
        $stored_pass = "9606f63cd663aa99934f1f57698590a2";
        if (hash('md5', $salt . $_POST['pass']) != $stored_pass) {
            $_SESSION['msg'] = '<p style="color:red;"> Password is incorrect!</p>';
            header('location: login.php');
            return;
        } else {
            $_SESSION['logedin'] = 'yes';
            $_SESSION['email'] = $_POST['email'];
            header('location: view.php');
            return;
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./style/style.css" />
</head>
<body>
    <div class="container">
        <h1>Please Log In</h1>
        
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        ?>


        <form method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" id="pass" name="pass">
            </div>     
            <br>
            <input type="submit" class="btn-primary" name="submit" value="Submit">
            <input type="submit" class="btn-primary" name="cancel" value="Cancel">


        </form>
        <br><br>
        <p class="hint">****Every valid email is accepted****</p><br>
        <p class="hint">****Password is <i>php123</i> ****</p>
    
    
    </div>
</body>
</html>