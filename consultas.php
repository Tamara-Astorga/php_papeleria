<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion/conexion.php';


require_once 'header_footer/header.php';
?>

    <!-- Contenido de la página -->

    <h1>Consultas</h1>

    <p>Elige un tipo de consulta.</p>

    <h2>Consultas Sencillas</h2>
    <a href="consulta1.php">1. Mostrar todas las ventas de un producto en específico.</a><br>
    <a href="consulta2.php">2. Mostrar todos los clientes que vivan en una región.</a><br>
    <a href="consulta3.php">3. Mostrar todos los empleados por género.</a><br>
    <a href="consulta4.php">4. Mostrar todos los productos que sean de una categoría.</a><br>
    <a href="consulta5.php">5. Mostrar todos los productos que tengan un precio unitario mayor a una cantidad.</a><br>

    <h2>Consultas con Parámetros</h2>
    <a href="consulta6.php">6. Mostrar todas las ventas por un rango de fecha inicio y fin.</a><br>
    <a href="consulta7.php">7. Mostrar todas las ventas que ha hecho un empleado en específico.</a><br>
    <a href="consulta8.php">8. Mostrar todas las compras de un producto en específico.</a><br>
    <a href="consulta9.php">9. Mostrar todas las compras por un rango de fecha inicio y fin.</a><br>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>