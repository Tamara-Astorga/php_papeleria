<?php
require_once 'conexion/conexion.php';

require_once 'header_footer/header.php';
?>

<h1>Mostrar todas las ventas por un rango de fecha inicio y fin.</h1>

<form method="POST" action="">
  <label for="fechaInicio">Fecha de Inicio:</label>
  <input type="date" name="fechaInicio" id="fechaInicio">

  <label for="fechaFin">Fecha de Fin:</label>
  <input type="date" name="fechaFin" id="fechaFin">

  <button type="submit">Buscar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fechaInicio = $_POST["fechaInicio"];
  $fechaFin = $_POST["fechaFin"];

  $stmt = $conexion->prepare("SELECT v.id_venta, v.fecha_venta, p.nombre_producto, CONCAT(c.nombre_cliente, ' - ', c.telefono_cliente) AS cliente, CONCAT(e.rfc, ' - ', e.nombre_empleado) AS empleado, pv.cantidad_comprada, v.total_venta
                             FROM tbl_ventas v
                             INNER JOIN tbl_productos_venta pv ON v.id_venta = pv.id_venta
                             INNER JOIN tbl_productos p ON pv.id_producto = p.id_producto
                             INNER JOIN tbl_clientes c ON v.id_cliente = c.id_cliente
                             INNER JOIN tbl_empleados e ON v.rfc_empleado = e.rfc
                             WHERE v.fecha_venta BETWEEN :fechaInicio AND :fechaFin");
  $stmt->bindValue(':fechaInicio', $fechaInicio . ' 00:00:00');
  $stmt->bindValue(':fechaFin', $fechaFin . ' 23:59:59');
  $stmt->execute();
  $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($ventas) > 0) {
    echo '<h2>Resultados de la búsqueda</h2>';
    echo '<table>';
    echo '<tr><th>ID Venta</th><th>Fecha</th><th>Producto</th><th>Cliente</th><th>Empleado</th><th>Cantidad</th><th>Total</th></tr>';
    foreach ($ventas as $venta) {
      echo '<tr>';
      echo '<td>' . $venta['id_venta'] . '</td>';
      echo '<td>' . $venta['fecha_venta'] . '</td>';
      echo '<td>' . $venta['nombre_producto'] . '</td>';
      echo '<td>' . $venta['cliente'] . '</td>';
      echo '<td>' . $venta['empleado'] . '</td>';
      echo '<td>' . $venta['cantidad_comprada'] . '</td>';
      echo '<td>' . $venta['total_venta'] . '</td>';
      echo '</tr>';
    }
    echo '</table>';

    $stmt = $conexion->prepare("SELECT SUM(total_venta) AS suma_ventas
                               FROM tbl_ventas
                               WHERE fecha_venta BETWEEN :fechaInicio AND :fechaFin");
    $stmt->bindValue(':fechaInicio', $fechaInicio . ' 00:00:00');
    $stmt->bindValue(':fechaFin', $fechaFin . ' 23:59:59');
    $stmt->execute();
    $sumaVentas = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalVentas = $sumaVentas['suma_ventas'];

    echo '<p>Suma total de ventas: ' . $totalVentas . '</p>';
  } else {
    echo '<script>alert("No hay ventas en el rango de fecha solicitado.");</script>';
  }
}
?>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
