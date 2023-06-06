<?php
require_once 'conexion/conexion.php';

require_once 'header_footer/header.php';

$resultados = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $producto = $_POST["producto"];

  $stmt = $conexion->prepare("SELECT id_producto, fecha_compra, proveedor, categoria, nombre_producto, descripcion_producto, precio_unitario, cantidad_stock
                             FROM tbl_productos
                             WHERE nombre_producto = :producto");
  $stmt->bindValue(':producto', $producto);
  $stmt->execute();
  $compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($compras) > 0) {
    $totalPrecios = 0;

    foreach ($compras as $compra) {
      $resultados[] = $compra;
      $totalPrecios += $compra['precio_unitario'];
    }
  } else {
    echo '<script>alert("No hay compras del producto seleccionado.");</script>';
  }
}
?>

<h1>Mostrar todas las compras de un producto en específico.</h1>

<form method="POST" action="">
  <label for="producto">Producto:</label>
  <select name="producto" id="producto">
    <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
    <?php
    $stmt = $conexion->prepare("SELECT DISTINCT nombre_producto FROM tbl_productos");
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($productos as $producto) {
      echo '<option value="' . $producto['nombre_producto'] . '">' . $producto['nombre_producto'] . '</option>';
    }
    ?>
  </select>
  <button type="submit">Buscar</button>
</form>

<?php
if (!empty($resultados)) {
  echo '<h2>Resultados de la búsqueda</h2>';
  echo '<table>';
  echo '<tr><th>ID Producto</th><th>Fecha Compra</th><th>Proveedor</th><th>Categoría</th><th>Nombre Producto</th><th>Descripción Producto</th><th>Precio Unitario</th><th>Cantidad Stock</th></tr>';

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
  echo '<p>Total precios unitarios: ' . $totalPrecios . '</p>';
}
?>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
