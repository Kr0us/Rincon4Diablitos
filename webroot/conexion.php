<?php
    // ---------- FUNCIONES DE BASE DE DATOS ----------
    // Ejecuta una consulta SQL (puede ser multi_query) y devuelve los resultados en un array asociativo
    function execute_query($conn, $sql) {
        $datos = [];

        if ($conn->multi_query($sql)) {
            do {
                if ($result = $conn->store_result()) {
                    while ($fila = $result->fetch_assoc()) {
                        $datos[] = $fila;
                    }
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        } else {
            throw new Exception("Error ejecutando consulta: " . $conn->error);
        }

        return $datos;
    }
    
    // Función para crear una conexión a la base de datos
    function create_conection(string $db) {
        // Leer variables de entorno desde el archivo .env
        $data = parse_ini_file(realpath(__DIR__."/..")."/.env", true);

        // Crear una nueva instancia de mysqli usando los datos de configuración
        $conn = new mysqli(
            $data[$db]["host"],   // Host de la base de datos
            $data[$db]["user"],   // Usuario de la base de datos
            $data[$db]["passwd"], // Contraseña del usuario
            $data[$db]["db"],     // Nombre de la base de datos
            (int)$data[$db]["port"] // Puerto de conexión (convertido a entero)
        );
    
        // Verificar si hubo error en la conexión
        if ($conn->connect_errno) {
            return NULL; // Retornar NULL si falla la conexión
        }
        return $conn; // Retornar el objeto de conexión si es exitosa
    }
?>