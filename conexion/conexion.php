<?php
$servername = "localhost"; // El servidor siempre va a ser local o poner la IP de la BD remota
$username = "root"; // Cambiar por tu nombre de usuario de la base de datos
$password = ""; // Cambiar por tu contraseña de la base de datos - en XAMPP por default esta vacía
$dbname = "papeleria"; //Cambiar pot el nombre de la base de datos

try {
    $conexion = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
