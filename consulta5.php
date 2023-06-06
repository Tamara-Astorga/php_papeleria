<?php
require_once 'conexion/conexion.php';

require_once 'header_footer/header.php';
?>

<h1>Mostrar todos los productos que tengan un precio unitario mayor a una cantidad.</h1>

<form method="POST" action="">
  <label for="precio_minimo">Precio Unitario mínimo:</label>
  <input type="number" name="precio_minimo" id="precio_minimo" step="0.01" placeholder="Precio..." required>
  <button type="submit">Buscar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $precioMinimo = $_POST["precio_minimo"];

  $stmt = $conexion->prepare("SELECT id_producto, fecha_compra, proveedor, categoria, nombre_producto, descripcion_producto, precio_unitario, cantidad_stock
                             FROM tbl_productos
                             WHERE precio_unitario > :precioMinimo");
  $stmt->bindValue(':precioMinimo', $precioMinimo);
  $stmt->execute();
  $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($productos) > 0) {
    echo '<h2>Resultados de la búsqueda</h2>';
    echo '<table>';
    echo '<tr><th>ID Producto</th><th>Fecha Compra</th><th>Proveedor</th><th>Categoría</th><th>Nombre Producto</th><th>Descripción Producto</th><th>Precio Unitario</th><th>Cantidad Stock</th></tr>';
    foreach ($productos as $producto) {
      echo '<tr>';
      echo '<td>' . $producto['id_producto'] . '</td>';
      echo '<td>' . $producto['fecha_compra'] . '</td>';
      echo '<td>' . $producto['proveedor'] . '</td>';
      echo '<td>' . $producto['categoria'] . '</td>';
      echo '<td>' . $producto['nombre_producto'] . '</td>';
      echo '<td>' . $producto['descripcion_producto'] . '</td>';
      echo '<td>' . $producto['precio_unitario'] . '</td>';
      echo '<td>' . $producto['cantidad_stock'] . '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } else {
    echo '<script>alert("No hay productos con un precio unitario mayor al valor especificado.");</script>';
  }
}
?>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
