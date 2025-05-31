<?php
require_once '../Usuarios/User.php';
require_once 'Catalogo.php';

$user = new User();
$catalogo = new Catalogo();

if (!$user->isAuthenticated()) {
    header('Location: ../Usuarios/login.php');
    exit;
}

if(!isset($_GET['id'])) {
    header('Location: catalogoModel.php');
    exit;
}

$libro = $catalogo->obtenerPorId($_GET['id']);

if(!$libro) {
    die('Libro no encontrado');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $libro['titulo'] ?></title>
    <style>
        .detalle { max-width: 600px; margin: 20px auto; }
        .portada { max-width: 200px; }
    </style>
</head>
<body>
    <h1>Bienvenido <?= $user->getCurrentUser() ?></h1>
    <a href="../Usuarios/logout.php">Cerrar sesión</a>
    <a href="catalogoModel.php">Volver al catálogo</a>
    <a href="../Prestamos/prestamos.php">Mis préstamos</a>
    <div class="detalle">
        <h1><?= $libro['titulo'] ?></h1>
        <h2>Autor: <?= $libro['autor'] ?></h2>
        <p>Año de publicación: <?= $libro['anio'] ?></p>
        <?php if($libro['portada']): ?>
        <img src="imagenes/<?= $libro['portada'] ?>" class="portada" alt="Portada">
        <?php endif; ?>
        <p><?= $libro['descripcion'] ?></p>
    </div>
</body>
</html>