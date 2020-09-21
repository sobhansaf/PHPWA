<?php
    require_once('pdo.php');
    require_once('selectuser.php');

    session_start();
    if (isset($_POST['cancel'])) {
        header('location: index.php');
        return;
    }

    if (isset($_POST['subbtn'])) {
        if (!isset($_POST['email']) || strlen($_POST['email']) < 1) {
            $_SESSION['signmsg'] = 'Email is required!';
            header('location: signin.php');
            return;
        } elseif (!preg_match('/[a-zA-Z0-9_-]+@([a-zA-Z0-9]+\.)+[a-zA-Z]{2,}/', $_POST['email'])) {
            $_SESSION['signmsg'] = 'Please enter a valid email.';
            header('location: signin.php');
            return;
        } elseif (!isset($_POST['pass']) || strlen($_POST['pass']) < 1)  {
            $_SESSION['signmsg'] = 'Password is required!';
            header('location: signin.php');
            return;
        } else {
            $email = $_POST['email'];

            $user = find_user($email, $pdo);

            if ($user) {
                $_SESSION['signmsg'] = 'Email already exists. Try another one please!';
                header('location: signin.php');
                return;
            }

            $pass = $_POST['pass'];
            $salt = bin2hex(random_bytes(8));
            $stmt = $pdo->prepare('INSERT INTO users(email, pass) VALUES (:email, :pass)');
            $pass_to_save = $salt . hash('md5', $salt . $pass);
            $stmt->execute([
                'email' => $email,
                'pass' => $pass_to_save
            ]);
            $_SESSION['logedin'] = 'yes';
            $_SESSION['email'] = $email;
            $_SESSION['id'] = find_user($email, $pdo)[0]['user_id'];
            header('location: view.php');
            return;
        }
    }



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In!</title>
    <link rel='stylesheet' href='./style/style.css' />
</head>
<body>
    <div class="container">
        <h1>Sign Up Form</h1>
        <?php
        if (isset($_SESSION['signmsg'])) {
            echo '<p style="color:red">' . $_SESSION['signmsg'] . '</p>';
            unset($_SESSION['signmsg']);
        }

        ?>
        <form method='post'>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name='email'>
            </div>
        
            <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" name='pass'>
            </div>

            <input type="submit" name='subbtn' value='Sign Up' class='btn-primary'>
            <input type="submit" name='cancel' value='Cancel' class='btn-primary red'>
        
        </form>
    
    </div>
</body>
</html>
