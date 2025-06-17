<?php
    function create_conection() {
        $data = parse_ini_file("../.env", true);
    
    
        $conn = new mysqli(
            $data["RINCON"]["host"],
            $data["RINCON"]["user"],
            $data["RINCON"]["passwd"],
            $data["RINCON"]["db"],
            (int)$data["RINCON"]["port"]
        );
    
        if ($conn->connect_errno) {
            return NULL;
        }
        return $conn;
    }
?>