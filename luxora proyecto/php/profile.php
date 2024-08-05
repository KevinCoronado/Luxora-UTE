<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header('Location: Login.html');
    exit();
}

echo 'Bienvenido, usuario con ID: ' . $_SESSION['user_id'];
?>