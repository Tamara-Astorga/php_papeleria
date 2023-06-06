<?php
require_once 'conexion/conexion.php';

require_once 'header_footer/header.php';

$stmt = $conexion->prepare("SELECT nombre_producto FROM tbl_productos");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Mostrar todas las ventas de un producto en específico.</h1>

<form method="POST" action="">
  <label for="nombre_producto">Producto:</label>
  <select name="nombre_producto" id="nombre_producto">
    <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
    <?php
    foreach ($productos as $producto) {
      echo '<option value="' . $producto['nombre_producto'] . '">' . $producto['nombre_producto'] . '</option>';
    }
    ?>
  </select>
  <button type="submit">Buscar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombreProducto = $_POST["nombre_producto"];

  $stmt = $conexion->prepare("SELECT p.nombre_producto, v.fecha_venta, c.nombre_cliente, CONCAT(e.rfc, ' - ', e.nombre_empleado) AS empleado, pv.cantidad_comprada, p.cantidad_stock, v.total_venta
                             FROM tbl_productos_venta pv
                             INNER JOIN tbl_ventas v ON pv.id_venta = v.id_venta
                             INNER JOIN tbl_productos p ON pv.id_producto = p.id_producto
                             INNER JOIN tbl_clientes c ON v.id_cliente = c.id_cliente
                             INNER JOIN tbl_empleados e ON v.rfc_empleado = e.rfc
                             WHERE p.nombre_producto = :nombre_producto");
  $stmt->bindParam(':nombre_producto', $nombreProducto);
  $stmt->execute();
  $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($ventas) > 0) {
    echo '<h2>Resultados de la búsqueda</h2>';
    echo '<table>';
    echo '<tr><th>Producto</th><th>Fecha Venta</th><th>Cliente</th><th>RFC - Empleado</th><th>Cantidad Comprada</th><th>Cantidad en Stock</th><th>Total Venta</th></tr>';
    foreach ($ventas as $venta) {
      echo '<tr>';
      echo '<td>' . $venta['nombre_producto'] . '</td>';
      echo '<td>' . $venta['fecha_venta'] . '</td>';
      echo '<td>' . $venta['nombre_cliente'] . '</td>';
      echo '<td>' . $venta['empleado'] . '</td>';
      echo '<td>' . $venta['cantidad_comprada'] . '</td>';
      echo '<td>' . $venta['cantidad_stock'] . '</td>';
      echo '<td>' . $venta['total_venta'] . '</td>';
      echo '</tr>';
    }
    echo '</table>';
    $stmt = $conexion->prepare("SELECT SUM(total_venta) AS suma_ventas
                               FROM tbl_ventas v
                               INNER JOIN tbl_productos_venta pv ON v.id_venta = pv.id_venta
                               INNER JOIN tbl_productos p ON pv.id_producto = p.id_producto
                               WHERE p.nombre_producto = :nombre_producto");
    $stmt->bindParam(':nombre_producto', $nombreProducto);
    $stmt->execute();
    $sumaVentas = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<p>Suma de ventas del producto: ' . $sumaVentas['suma_ventas'] . '</p>';
  } else {
    echo '<script>alert("No se han realizado ventas del producto especificado.");</script>';
  }
}
?>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
