<?php
$dsn = "mysql:dbname=misc;host=localhost";
$pdo = new PDO($dsn, 'autos_user', '123456');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

