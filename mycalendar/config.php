<?php
// Conecta ao banco de dados
$dsn = 'mysql:dbname=projeto_login;host=localhost;charset=utf8';
$user = 'root';
$password = '';

try {
	$pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
