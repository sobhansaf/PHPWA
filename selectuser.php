<?php

function find_user($email, $pdo){
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email=?');
    $stmt->execute([$email]);
    return $stmt->fetchall(PDO::FETCH_ASSOC);
}

function check_user($email, $pass, $pdo) {
    $users = find_user($email, $pdo);
    if (!$users) {
        return false;
    }
    foreach ($users as $user) {
        $salt_pass_enc = $user['pass'];
        $salt = substr($salt_pass_enc, 0, 16);
        $pass_enc = substr($salt_pass_enc, 16);
        if (hash('md5', $salt . $pass) === $pass_enc) {
            return true;
        }
    }
    return false;
}


