<?php
require '../config/db.php';
require '../src/Auth.php';

$auth = new Auth($pdo);
$auth->register('ana', '1234'); // Registra un usuario
echo $auth->login('ana', '1234') ? "Login exitoso" : "Login fallido";
