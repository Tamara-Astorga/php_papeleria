<?php
require_once 'conexion/conexion.php';

require_once 'header_footer/header.php';

$resultados = [];
$totalPrecioUnitario = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fechaInicio = $_POST["fecha_inicio"];
  $fechaFin = $_POST["fecha_fin"];

  $stmt = $conexion->prepare("SELECT p.id_producto, p.fecha_compra, p.proveedor, p.categoria, p.nombre_producto, p.descripcion_producto, p.precio_unitario, p.cantidad_stock
                             FROM tbl_productos p
                             WHERE p.fecha_compra BETWEEN :fechaInicio AND :fechaFin");
  $stmt->bindParam(':fechaInicio', $fechaInicio);
  $stmt->bindParam(':fechaFin', $fechaFin);
  $stmt->execute();
  $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Calcular la suma total del precio unitario
  foreach ($resultados as $compra) {
    $totalPrecioUnitario += $compra['precio_unitario'];
  }
}

?>

<h1>Mostrar todas las compras por un rango de fecha inicio y fin.</h1>

<form method="POST" action="">
  <label for="fecha_inicio">Fecha de Inicio:</label>
  <input type="date" name="fecha_inicio" id="fecha_inicio">

  <label for="fecha_fin">Fecha de Fin:</label>
  <input type="date" name="fecha_fin" id="fecha_fin">

  <button type="submit">Buscar</button>
</form>

<?php
if (!empty($resultados)) {
  echo '<h2>Resultados de la búsqueda</h2>';
  echo '<table>';
  echo '<tr><th>ID Producto</th><th>Fecha Compra</th><th>Proveedor</th><th>Categoría</th><th>Nombre Producto</th><th>Descripción</th><th>Precio Unitario</th><th>Cantidad en Stock</th></tr>';
  foreach ($resultados as $compra) {
    echo '<tr>';
    echo '<td>' . $compra['id_producto'] . '</td>';
    echo '<td>' . $compra['fecha_compra'] . '</td>';
    echo '<td>' . $compra['proveedor'] . '</td>';
    echo '<td>' . $compra['categoria'] . '</td>';
    echo '<td>' . $compra['nombre_producto'] . '</td>';
    echo '<td>' . $compra['descripcion_producto'] . '</td>';
    echo '<td>' . $compra['precio_unitario'] . '</td>';
    echo '<td>' . $compra['cantidad_stock'] . '</td>';
    echo '</tr>';
  }
  echo '</table>';
  echo '<p>Suma Total de compras: ' . $totalPrecioUnitario . '</p>';
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo '<script>alert("No se encontraron compras en el rango de fechas especificado.");</script>';
}
?>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
