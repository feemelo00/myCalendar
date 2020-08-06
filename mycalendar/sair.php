<?php
// Inicia sessão
session_start();
// Desativa sessão
unset($_SESSION['id']);
// Redireciona
header("Location: index.html");
exit();
