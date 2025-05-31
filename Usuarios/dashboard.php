<?php
require_once 'User.php';
$user = new User();

if (!$user->isAuthenticated()) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Bienvenido <?= $user->getCurrentUser() ?></h1>
    <a href="../Catalogo/catalogoModel.php">Ver catálogo</a>
    <a href="logout.php">Cerrar sesión</a>
    <a href="../Prestamos/prestamos.php">Mis préstamos</a>
</body>
</html>