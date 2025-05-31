<?php
// Prestamos/LoanManager.php
require_once __DIR__ . '/../Usuarios/User.php';
require_once __DIR__ . '/../Catalogo/Catalogo.php';

class LoanManager {
    private $user;
    private $catalogo;

    public function __construct() {
        $this->user = new User();
        $this->catalogo = new Catalogo();
        session_start();
    }

    /**
     * Obtiene todos los préstamos del usuario actual
     */
    public function obtenerPrestamos() {
        return $_SESSION['prestamos'] ?? [];
    }

    /**
     * Realiza un préstamo
     */
    public function prestar($libroId) {
        if(!$this->user->isAuthenticated()) return false;
        
        $libro = $this->catalogo->obtenerPorId($libroId);
        if($libro && !$this->estaPrestado($libroId)) {
            $_SESSION['prestamos'][$libroId] = [
                'fecha_prestamo' => date('Y-m-d H:i:s'),
                'libro' => $libro
            ];
            return true;
        }
        return false;
    }

    /**
     * Devuelve un libro
     */
    public function devolver($libroId) {
        if(isset($_SESSION['prestamos'][$libroId])) {
            unset($_SESSION['prestamos'][$libroId]);
            return true;
        }
        return false;
    }

    /**
     * Verifica si un libro está prestado
     */
    public function estaPrestado($libroId) {
        return isset($_SESSION['prestamos'][$libroId]);
    }
}
?>