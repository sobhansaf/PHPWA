<?php

session_start();

function get_auto($pdo, $auto_id) {
    $stmt = $pdo->prepare('SELECT * FROM autos WHERE autos_id=?');
    $stmt->execute([$_POST['id']]);
    if ($stmt !== false){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $row = false;
    }
    return $row;
}


require_once('pdo.php');


if (!isset($_SESSION['logedin']) || $_SESSION['logedin'] != 'yes') {
    die('You are not LOGED IN!');
}

if (isset($_POST['cancel'])) {
    header('location: view.php');
    return;
} elseif (isset($_POST['submit'])) {
    if (!isset($_POST['id']) || strlen($_POST['id']) < 1) {
        $_SESSION['msg'] = '<p style="color:red">Wrong ID to delete</p>';
        header('location: view.php');
        return;
    }
    $row = get_auto($pdo, $_POST['id']);
    if ($row === false) {
        $_SESSION['msg'] = '<p style="color:red">There is no car with given ID in database</p>';
        header('location: view.php');
        return;
    }
    $stmt = $pdo->prepare('DELETE FROM autos WHERE autos_id=?');
    $stmt->execute([$_POST['id']]);
    $_SESSION['msg'] = '<p style="color:green">Deleted successfully! </p>';
    header('location: view.php');
    return;
    
}

if (!isset($_POST['id']) || strlen($_POST['id']) < 1) {
    $_SESSION['msg'] = '<p style="color:red">Wrong ID to delete</p>';
    header('location: view.php');
    return;
}

$row = get_auto($pdo, $_POST['id']);
if ($row === false) {
    $_SESSION['msg'] = '<p style="color:red">There is no car with given ID in database</p>';
    header('location: view.php');
    return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style/style.css" />
</head>
<body>
    <div class="container">
        <h1>Deleting...</h1>
        <p>Are you sure? Delete (<?= htmlentities($row['model']) . ' ' . htmlentities($row['make']) . ' '. 
        htmlentities($row['year']) . ' ' . htmlentities($row['mileage'])?>)</p>

        <form method="post">
            <input type="hidden" name="id" value=<?= $row['autos_id'] ?>>
            <input type="submit" class="btn-primary" name="submit" value="Yes">
            <input type="submit" class="btn-primary" name="cancel" value="No">
        </form>


    </div>
</body>
</html>



