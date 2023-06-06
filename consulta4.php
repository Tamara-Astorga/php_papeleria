<?php
require_once 'conexion/conexion.php';

require_once 'header_footer/header.php';
?>

<h1>Mostrar todos los productos que sean de una categoría.</h1>

<form method="POST" action="">
  <label for="categoria">Categoría:</label>
  <select name="categoria" id="categoria">
    <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
    <option value="Escritura">Escritura</option>
    <option value="Bolígrafos y lápices">Bolígrafos y lápices</option>
    <option value="Útiles de escritura">Útiles de escritura</option>
    <option value="Cuadernos y libretas">Cuadernos y libretas</option>
    <option value="Archivo y organización">Archivo y organización</option>
    <option value="Material de dibujo y pintura">Material de dibujo y pintura</option>
    <option value="Accesorios de oficina">Accesorios de oficina</option>
    <option value="Papelería corporativa">Papelería corporativa</option>
    <option value="Material didáctico">Material didáctico</option>
    <option value="Artículos de embalaje">Artículos de embalaje</option>
  </select>
  <button type="submit">Buscar</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $categoria = $_POST["categoria"];

  $stmt = $conexion->prepare("SELECT id_producto, fecha_compra, proveedor, categoria, nombre_producto, descripcion_producto, precio_unitario, cantidad_stock
                             FROM tbl_productos
                             WHERE categoria = :categoria");
  $stmt->bindValue(':categoria', $categoria);
  $stmt->execute();
  $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($productos) > 0) {
    echo '<h2>Resultados de la búsqueda</h2>';
    echo '<table>';
    echo '<tr><th>ID Producto</th><th>Fecha Compra</th><th>Proveedor</th><th>Categoría</th><th>Nombre Producto</th><th>Descripción Producto</th><th>Precio Unitario</th><th>Cantidad en Stock</th></tr>';
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
    echo '<script>alert("No existen productos en la categoría especificada.");</script>';
  }
}
?>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
