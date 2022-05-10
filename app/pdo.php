<?php
$dsn = "mysql:dbname=" . getenv("db_name") .";host=" . getenv("db_host");
$pdo = new PDO($dsn, getenv("db_user"), getenv("db_pass"));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

