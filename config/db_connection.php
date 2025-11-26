<?php
/*------------------------------------------------------------
 | Configuración de conexión a la base de datos
 *-----------------------------------------------------------*/
$server   = "localhost";
$user     = "root";
$password = "";
$db       = "objetos_perdidos";


/*------------------------------------------------------------
 | Creación de la conexión usando mysqli
 *-----------------------------------------------------------*/
$connection = new mysqli($server, $user, $password, $db);


/*------------------------------------------------------------
 | Validar si ocurrió un error al conectar
 *-----------------------------------------------------------*/
if ($connection->connect_errno) {
    die("Error en la conexión a la base de datos: " . $connection->connect_error);
} else {
    // Conexión exitosa (se deja vacío para evitar mostrar texto en pantalla)
    // echo "Conexión exitosa";
}
