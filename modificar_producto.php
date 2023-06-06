<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion/conexion.php';
// Incluir el archivo de funciones
require_once 'funciones/funciones.php';

// Verificar si se envió el formulario de modificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProducto = $_POST['id_producto'];
    $proveedorProducto = $_POST['proveedor'];
    $categoriaProducto = $_POST['categoria'];
    $nombreProducto = $_POST['nombre_producto'];
    $descripcionProducto = $_POST['descripcion_producto'];
    $precioUnitario = $_POST['precio_unitario'];
    $cantidadStock = $_POST['cantidad_stock'];

    // Validar el formulario
    if (validarFormularioProductos($proveedorProducto, $categoriaProducto, $nombreProducto, $descripcionProducto, $precioUnitario, $cantidadStock)) {
        actualizarProducto($idProducto, $proveedorProducto, $categoriaProducto, $nombreProducto, $descripcionProducto, $precioUnitario, $cantidadStock, $conexion);
        header('Location: productos.php');
        exit();
    } else {
        echo '<script>alert("Los campos contienen caracteres no permitidos o los valores no son válidos");</script>';
    }
}

// Obtener el ID del producto a modificar
if (isset($_GET['id'])) {
    $idProducto = $_GET['id'];
    $producto = obtenerProductoPorID($idProducto, $conexion);
    if (!$producto) {
        echo 'Producto no encontrado';
        exit();
    }
} else {
    echo 'ID de producto no especificado';
    exit();
}


require_once 'header_footer/header.php';
?>

    <!-- Contenido de la página -->

    <h1>Modificar producto</h1>

    <p>Por favor modifica los datos del producto.</p>

    <form method="POST" action="modificar_producto.php">
        <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">

        <label for="proveedor">Proveedor:</label>
        <input type="text" name="proveedor" maxlength="60" id="proveedor" value="<?php echo $producto['proveedor']; ?>" placeholder="Ingresa un nombre..." required><br>

        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria" required>
            <option value="Escritura" <?php if ($producto['categoria'] === 'Escritura') echo 'selected'; ?>>Escritura</option>
            <option value="Bolígrafos y lápices" <?php if ($producto['categoria'] === 'Bolígrafos y lápices') echo 'selected'; ?>>Bolígrafos y lápices</option>
            <option value="Útiles de escritura" <?php if ($producto['categoria'] === 'Útiles de escritura') echo 'selected'; ?>>Útiles de escritura</option>
            <option value="Cuadernos y libretas" <?php if ($producto['categoria'] === 'Cuadernos y libretas') echo 'selected'; ?>>Cuadernos y libretas</option>
            <option value="Archivo y organización" <?php if ($producto['categoria'] === 'Archivo y organización') echo 'selected'; ?>>Archivo y organización</option>
            <option value="Material de dibujo y pintura" <?php if ($producto['categoria'] === 'Material de dibujo y pintura') echo 'selected'; ?>>Material de dibujo y pintura</option>
            <option value="Accesorios de oficina" <?php if ($producto['categoria'] === 'Accesorios de oficina') echo 'selected'; ?>>Accesorios de oficina</option>
            <option value="Papelería corporativa" <?php if ($producto['categoria'] === 'Papelería corporativa') echo 'selected'; ?>>Papelería corporativa</option>
            <option value="Material didáctico" <?php if ($producto['categoria'] === 'Material didáctico') echo 'selected'; ?>>Material didáctico</option>
            <option value="Artículos de embalaje" <?php if ($producto['categoria'] === 'Artículos de embalaje') echo 'selected'; ?>>Artículos de embalaje</option>
        </select><br>

        <label for="nombre_producto">Nombre:</label>
        <input type="text" name="nombre_producto" id="nombre_producto" value="<?php echo $producto['nombre_producto']; ?>" placeholder="Ingresa un nombre..." required><br>

        <label for="descripcion_producto">Descripción:</label>
        <textarea name="descripcion_producto" id="descripcion_producto" placeholder="Ingresa una descripción..." required><?php echo $producto['descripcion_producto']; ?></textarea><br>

        <label for="precio_unitario">Precio unitario:</label>
        <input type="number" name="precio_unitario" id="precio_unitario" step="0.01" value="<?php echo $producto['precio_unitario']; ?>" placeholder="Precio..." required><br>

        <label for="cantidad_stock">Cantidad en stock:</label>
        <input type="number" name="cantidad_stock" id="cantidad_stock" value="<?php echo $producto['cantidad_stock']; ?>" placeholder="Cantidad..." required><br>

        <input type="submit" value="Actualizar">
        <input type="submit" href="productos.php" value="Cancelar">
    </form>

<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
