<?php
    // Función para crear una conexión a la base de datos
    function create_conection() {
        // Leer variables de entorno desde el archivo .env
        $data = parse_ini_file("../.env", true);
    
        // Crear una nueva instancia de mysqli usando los datos de configuración
        $conn = new mysqli(
            $data["RINCON"]["host"],   // Host de la base de datos
            $data["RINCON"]["user"],   // Usuario de la base de datos
            $data["RINCON"]["passwd"], // Contraseña del usuario
            $data["RINCON"]["db"],     // Nombre de la base de datos
            (int)$data["RINCON"]["port"] // Puerto de conexión (convertido a entero)
        );
    
        // Verificar si hubo error en la conexión
        if ($conn->connect_errno) {
            return NULL; // Retornar NULL si falla la conexión
        }
        return $conn; // Retornar el objeto de conexión si es exitosa
    }
?>