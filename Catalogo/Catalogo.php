<?php
// Catalogo.php - Clase para manejar el catálogo de libros
class Catalogo {
    private static $libros = [
        [
            'id' => 1,
            'titulo' => 'Cien años de soledad',
            'autor' => 'Gabriel García Márquez',
            'anio' => 1967,
            'descripcion' => 'Una saga familiar en el pueblo mágico de Macondo.',
            'portada' => 'cien-anios.png'
        ],
        [
            'id' => 2,
            'titulo' => 'Rayuela',
            'autor' => 'Julio Cortázar',
            'anio' => 1963,
            'descripcion' => 'Novela experimental que se puede leer de múltiples formas.',
            'portada' => 'rayuela.png'
        ],
        [
            'id' => 3,
            'titulo' => 'Ficciones',
            'autor' => 'Jorge Luis Borges',
            'anio' => 1944,
            'descripcion' => 'Colección de cuentos de realismo mágico y filosofía.',
            'portada' => 'ficciones.png'
        ]
    ];

    /**
     * Obtiene todos los libros
     */
    public function obtenerTodos() {
        return self::$libros;
    }

    /**
     * Busca libros por título o autor
     */
    public function buscar($query) {
        return array_filter(self::$libros, function($libro) use ($query) {
            return stripos($libro['titulo'], $query) !== false || 
                   stripos($libro['autor'], $query) !== false;
        });
    }

    /**
     * Obtiene un libro por ID
     */
    public function obtenerPorId($id) {
        foreach(self::$libros as $libro) {
            if($libro['id'] == $id) {
                return $libro;
            }
        }
        return null;
    }

    /**
     * Obtiene libro destacado
     */
    public function obtenerDestacado() {
        return self::$libros[array_rand(self::$libros)];
    }
}
?>