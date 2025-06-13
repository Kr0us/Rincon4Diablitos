
<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST["nombre"] ?? '');
        $email = trim($_POST["email"] ?? '');
        $telefono = trim($_POST["telefono"] ?? '');
        $mensaje = trim($_POST["mensaje"] ?? '');

        $errores = [];

        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio.";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no es válido.";
        }

        if (empty($telefono)) {
            $errores[] = "El teléfono es obligatorio.";
        }

        if (empty($mensaje)) {
            $errores[] = "El mensaje es obligatorio.";
        }

        if (empty($errores)) {
            // Guardar en archivo CSV
            $archivo = fopen("contacto.csv", "a");
            fputcsv($archivo, [$nombre, $email, $telefono, $mensaje, date("Y-m-d H:i:s")]);
            fclose($archivo);
            echo "Mensaje enviado correctamente.";
        } else {
            foreach ($errores as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
        }
    }

?>