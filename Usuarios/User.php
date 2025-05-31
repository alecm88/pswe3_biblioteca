<?php
// User.php - Clase para manejo de usuarios
class User {
    private static $testUser = [
        'username' => 'testuser',
        'password_hash' => '$2y$10$id5e.27FBg7j1QqYeNEGDOs8Q3lOwEHkdscu/xj5SDEdwrI.JNj8m' // password = "testpass"
    ];

    public function __construct() {
        session_start();
    }

    /**
     * Intento de login
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login($username, $password) {
        if ($username === self::$testUser['username'] && 
            password_verify($password, self::$testUser['password_hash'])) {
            
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            return true;
        }
        return false;
    }

    /**
     * Cierra la sesión
     */
    public function logout() {
        session_unset();
        session_destroy();
    }

    /**
     * Verifica si el usuario está autenticado
     * @return bool
     */
    public function isAuthenticated() {
        return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    }

    /**
     * Obtiene el nombre de usuario actual
     * @return string|null
     */
    public function getCurrentUser() {
        return $_SESSION['username'] ?? null;
    }
}
?>