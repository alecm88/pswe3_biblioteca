<?php
require_once '../Usuarios/User.php';
require_once '../Catalogo/Catalogo.php';
require_once 'LoanManager.php';

$user = new User();
$prestamosManager = new LoanManager();

if (!$user->isAuthenticated()) {
    header('Location: ../Usuarios/login.php');
    exit;
}

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $libroId = $_POST['libro_id'] ?? 0;
    
    switch($action) {
        case 'prestar':
            $prestamosManager->prestar($libroId);
            break;
            
        case 'devolver':
            $prestamosManager->devolver($libroId);
            break;
    }
    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

$prestamos = $prestamosManager->obtenerPrestamos();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis Préstamos</title>
    <style>
        .prestamo { border: 1px solid #ddd; padding: 15px; margin: 10px; }
    </style>
</head>
<body>
    <h1>Mis Préstamos</h1>
    <a href="../Catalogo/catalogoModel.php">Volver al catálogo</a>
    
    <?php if(empty($prestamos)): ?>
        <p>No tienes libros prestados actualmente.</p>
    <?php else: ?>
        <?php foreach($prestamos as $prestamo): ?>
        <div class="prestamo">
            <h3><?= $prestamo['libro']['titulo'] ?></h3>
            <p>Autor: <?= $prestamo['libro']['autor'] ?></p>
            <p>Fecha de préstamo: <?= $prestamo['fecha_prestamo'] ?></p>
            <form method="POST" action="prestamos.php">
                <input type="hidden" name="action" value="devolver">
                <input type="hidden" name="libro_id" value="<?= $prestamo['libro']['id'] ?>">
                <button type="submit">Devolver libro</button>
            </form>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>