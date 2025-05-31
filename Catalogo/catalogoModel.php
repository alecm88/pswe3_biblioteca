<?php
require_once '../Usuarios/User.php';
require_once 'Catalogo.php';
require_once '../Prestamos/LoanManager.php';

$user = new User();
$catalogo = new Catalogo();
$prestamos = new LoanManager();

if (!$user->isAuthenticated()) {
    header('Location: Usuarios/login.php');
    exit;
}

$libros = $catalogo->obtenerTodos();
$destacado = $catalogo->obtenerDestacado();

// Manejar búsqueda
if(isset($_GET['busqueda'])) {
    $libros = $catalogo->buscar($_GET['busqueda']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Catálogo de Libros</title>
    <style>
        .libro { border: 1px solid #ccc; padding: 15px; margin: 10px; }
        .destacado { background-color: #ffeeba; }
        .portada { max-width: 150px; }
    </style>
</head>
<body>
    <h1>Bienvenido <?= $user->getCurrentUser() ?></h1>
    <a href="../Usuarios/logout.php">Cerrar sesión</a>
    <a href="../Prestamos/prestamos.php">Mis préstamos</a>

    <h2>Catálogo de Libros</h2>
    
    <!-- Formulario de búsqueda -->
    <form method="GET">
        <input type="text" name="busqueda" placeholder="Buscar por título o autor">
        <button type="submit">Buscar</button>
        <a href="catalogoModel.php">Ver todos</a>
    </form>

    <!-- Libro destacado -->
    <div class="libro destacado">
        <h3>Destacado del mes:</h3>
        <h4><?= $destacado['titulo'] ?></h4>
        <p>Autor: <?= $destacado['autor'] ?></p>
        <p>Año: <?= $destacado['anio'] ?></p>
        <a href="detalle.php?id=<?= $destacado['id'] ?>">Ver detalle</a>
    </div>

    <!-- Listado de libros -->
    <?php foreach($libros as $libro): ?>
    <div class="libro">
        <h3><?= $libro['titulo'] ?></h3>
        <p>Autor: <?= $libro['autor'] ?></p>
        <p>Año: <?= $libro['anio'] ?></p>
        <a href="detalle.php?id=<?= $libro['id'] ?>">Ver detalle</a>
        
        <?php if($prestamos->estaPrestado($libro['id'])): ?>
            <p style="color:green;">Libro prestado</p>
        <?php else: ?>
            <form method="POST" action="../Prestamos/prestamos.php">
                <input type="hidden" name="action" value="prestar">
                <input type="hidden" name="libro_id" value="<?= $libro['id'] ?>">
                <button type="submit">Pedir préstamo</button>
            </form>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</body>
</html>