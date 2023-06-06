<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion/conexion.php';
// Incluir el archivo de funciones
require_once 'funciones/funciones.php';

// Insertar datos en la base de datos cuando se envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proveedorProducto = $_POST['proveedor'];
    $categoriaProducto = $_POST['categoria'];
    $nombreProducto = $_POST['nombre_producto'];
    $descripcionProducto = $_POST['descripcion_producto'];
    $precioUnitario = $_POST['precio_unitario'];
    $cantidadStock = $_POST['cantidad_stock'];

    // Establecer la zona horaria a la de la Ciudad de México
    date_default_timezone_set('America/Mexico_City');

    // Validar el formulario
    if (validarFormularioProductos($proveedorProducto, $categoriaProducto, $nombreProducto, $descripcionProducto, $precioUnitario, $cantidadStock)) {
        insertarProducto(date('Y-m-d H:i:s'), $proveedorProducto, $categoriaProducto, $nombreProducto, $descripcionProducto, $precioUnitario, $cantidadStock, $conexion);
    } else {
        echo '<script>alert("Los campos contienen caracteres no permitidos o no se han proporcionado valores válidos");</script>';
    }
    
}

// Eliminar producto si se ha enviado el parámetro "eliminar"
if (isset($_GET['eliminar'])) {
    $idProductoEliminar = $_GET['eliminar'];
    eliminarProducto($idProductoEliminar, $conexion);
    // Redirigir a la página de productos.php para refrescar la tabla
    header("Location: productos.php");
    exit();
}

// Obtener los registros de la tabla tbl_productos
$productos = obtenerProductos($conexion);


require_once 'header_footer/header.php';
?>

    <!-- Contenido de la página -->

    <h1>Productos</h1>

    <p>Captura los datos del producto.</p>

    <form method="POST" action="productos.php">

        <label for="proveedor">Proveedor:</label>
        <input type="text" name="proveedor" maxlength="60" id="proveedor" placeholder="Ingresa un nombre..." required><br>

        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria" required>
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
        </select><br>

        <label for="nombre_producto">Nombre:</label>
        <input type="text" name="nombre_producto" maxlength="50" id="nombre_producto" placeholder="Ingresa un nombre..." required><br>

        <label for="descripcion_producto">Descripción:</label>
        <textarea name="descripcion_producto" maxlength="60" id="descripcion_producto" placeholder="Ingresa una descripción..." required></textarea><br>

        <label for="precio_unitario">Precio unitario:</label>
        <input type="number" name="precio_unitario" id="precio_unitario" step="0.01" placeholder="Precio..." required><br>

        <label for="cantidad_stock">Cantidad en stock:</label>
        <input type="number" name="cantidad_stock" id="cantidad_stock" placeholder="Cantidad..." required><br>

        <input type="submit" value="Insertar">
    </form>

    <h2>Registros de Productos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Fecha de compra</th>
            <th>Proveedor</th>
            <th>Categoría</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio unitario</th>
            <th>Cantidad en stock</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?php echo $producto['id_producto']; ?></td>
            <td><?php echo $producto['fecha_compra']; ?></td>
            <td><?php echo $producto['proveedor']; ?></td>
            <td><?php echo $producto['categoria']; ?></td>
            <td><?php echo $producto['nombre_producto']; ?></td>
            <td><?php echo $producto['descripcion_producto']; ?></td>
            <td><?php echo $producto['precio_unitario']; ?></td>
            <td><?php echo $producto['cantidad_stock']; ?></td>
            <td>
                <a href="productos.php?eliminar=<?php echo $producto['id_producto']; ?>">Eliminar</a>
                <a href="modificar_producto.php?id=<?php echo $producto['id_producto']; ?>">Modificar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
