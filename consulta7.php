<?php
require_once 'conexion/conexion.php';
require_once 'header_footer/header.php';

// Obtener la lista de empleados
$stmt = $conexion->query("SELECT CONCAT(rfc, ' - ', nombre_empleado) AS empleado FROM tbl_empleados");
$empleados = $stmt->fetchAll(PDO::FETCH_COLUMN);

$ventas = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $empleado = $_POST["empleado"];

  // Obtener el RFC del empleado seleccionado
  $rfc_empleado = substr($empleado, 0, 13);

  // Obtener las ventas del empleado
  $stmt = $conexion->prepare("SELECT v.id_venta, v.fecha_venta, p.nombre_producto, CONCAT(c.nombre_cliente, ' - ', c.telefono_cliente) AS cliente, CONCAT(e.rfc, ' - ', e.nombre_empleado) AS empleado, pv.cantidad_comprada, v.total_venta
                             FROM tbl_ventas v
                             INNER JOIN tbl_productos_venta pv ON v.id_venta = pv.id_venta
                             INNER JOIN tbl_productos p ON pv.id_producto = p.id_producto
                             INNER JOIN tbl_clientes c ON v.id_cliente = c.id_cliente
                             INNER JOIN tbl_empleados e ON v.rfc_empleado = e.rfc
                             WHERE v.rfc_empleado = :rfc_empleado");
  $stmt->bindValue(':rfc_empleado', $rfc_empleado);
  $stmt->execute();
  $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<h1>Mostrar todas las ventas que ha hecho un empleado en específico.</h1>

<form method="POST" action="">
  <label for="empleado">Empleado:</label>
  <select name="empleado" id="empleado">
    <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
    <?php
    foreach ($empleados as $empleado) {
      echo '<option value="' . $empleado . '">' . $empleado . '</option>';
    }
    ?>
  </select>
  <button type="submit">Buscar</button>
</form>

<?php
if (count($ventas) > 0) {
  // Calcular la suma de las ventas totales del empleado
  $suma_ventas = array_sum(array_column($ventas, 'total_venta'));

  echo '<h2>Resultados de la búsqueda</h2>';
  echo '<table>';
  echo '<tr><th>ID Venta</th><th>Fecha Venta</th><th>Producto</th><th>Cliente</th><th>Empleado</th><th>Cantidad</th><th>Total Venta</th></tr>';
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
  echo '<p>Suma de Ventas Totales: ' . $suma_ventas . '<p>';
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo '<script>alert("No se encontraron ventas para el empleado seleccionado.");</script>';
}

require_once 'header_footer/header.php';
?>

</body>
</html>
