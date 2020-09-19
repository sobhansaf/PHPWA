<?php
require_once('pdo.php');

session_start();

if (!isset($_SESSION['logedin']) || $_SESSION['logedin'] != 'yes'){
    die('You are not LOGED IN');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autos</title>
    <link rel="stylesheet" href="style/style.css" />
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
        <p><a href="add.php">Add New</a> | <a href="logout.php">Logout</a></p>
        <h1>Automobiles:</h1>
        <ul class="open-ul">
            <?php
            $stmt = $pdo->query('SELECT * FROM autos');
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>" . htmlentities($row['make']) . ' / ' . htmlentities($row['model']) . ' / ' . 
                htmlentities($row['year']) . ' / ' . htmlentities($row['mileage']) . '  ';
            ?>

            <form method="post" class="hidden-form" action="delete.php">
                <input type="hidden" name="id" value=<?= $row['autos_id'] ?>>
                <input type="submit" class="btn-primary btn-small red" value="Delete">
            </form>

            <?php
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>