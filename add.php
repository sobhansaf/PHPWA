<?php
require_once('pdo.php');

session_start();


if (!isset($_SESSION['logedin']) || $_SESSION['logedin'] != 'yes') {
    die('You are not LOGED IN!');
}

if (isset($_POST['cancel'])) {
    header('location: view.php');
    return;
} elseif (isset($_POST['submit'])){
    if (!isset($_POST['make']) || strlen($_POST['make']) < 1 || !isset($_POST['year']) || strlen($_POST['year']) < 1) {
        $_SESSION['msg'] = '<p style="color:red">All of the inputs are required! </p>';
        header('location: add.php');
        return;
    } elseif (!isset($_POST['model']) || strlen($_POST['model']) < 1 || !isset($_POST['mileage']) || strlen($_POST['mileage']) < 1) {
        $_SESSION['msg'] = '<p style="color:red">All of the inputs are required! </p>';
        header('location: add.php');
        return;
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['msg'] = '<p style="color:red">mileage and year should be numeric!</p>';
        header('location: add.php');
        return;
    } else {
        $_SESSION['msg'] = '<p style="color:green">Auto added successfully!</p>';
        $stmt = $pdo->prepare('INSERT INTO autos(make, model, year, mileage) VALUES (:make, :model, :year, :mileage)');
        $stmt->execute([
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage']
        ]);
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
    <title>Add new auto</title>
    <link rel="stylesheet" href="./style/style.css" />
</head>
<body>
    <div class="container">

    <h1>Tracking Autos for <?= $_SESSION['email'] ?></h1>

    <?php
    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>
    
    <form method="post">
        <div class="form-group">
            <label for="make">Make:</label>
            <input type="text" id="make" name="make" size=50>
        </div>
        <div class="form-group">
            <label for="year">Year:</label>
            <input type="text" id="year" name="year">
        </div>     
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" id="model" name="model">
        </div>     
        <div class="form-group">
            <label for="mileage">Mileage:</label>
            <input type="text" id="mileage" name="mileage">
        </div>     

        <br>
        <input type="submit" class="btn-primary" name="submit" value="Add">
        <input type="submit" class="btn-primary" name="cancel" value="Cancel">
    </form>
    
    </div>
</body>
</html>