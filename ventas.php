<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion/conexion.php';
// Incluir el archivo de funciones
require_once 'funciones/funciones.php';

// Obtener la lista de productos disponibles en stock
$productosDisponibles = obtenerProductosDisponibles($conexion);

// Obtener la lista de clientes
$clientes = obtenerClientes($conexion);

// Obtener la lista de empleados
$empleados = obtenerEmpleados($conexion);

// Verificar si se envió el formulario de venta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProducto = $_POST['producto'];
    $idCliente = $_POST['cliente'];
    $rfcEmpleado = $_POST['empleado'];
    $cantidadComprada = $_POST['cantidad'];

    // Establecer la zona horaria a la de la Ciudad de México
    date_default_timezone_set('America/Mexico_City');

    // Verificar si la cantidad comprada supera la cantidad en stock
    $cantidadStock = obtenerCantidadStock($idProducto, $conexion);
    if ($cantidadComprada > $cantidadStock) {
        echo '<script>alert("La cantidad solicitada excede la cantidad en stock.");</script>';
    } else {
        // Calcular el total de la venta
        $producto = obtenerProductoPorID($idProducto, $conexion);
        $precioUnitario = $producto['precio_unitario'];
        $totalVenta = $precioUnitario * $cantidadComprada;

        // Insertar la venta en la tabla de ventas
        $idVenta = insertarVenta(date('Y-m-d H:i:s'), $idCliente, $rfcEmpleado, $totalVenta, $conexion);

        // Insertar el producto vendido en la tabla de productos_venta
        insertarProductoVenta($idVenta, $idProducto, $cantidadComprada, $conexion);

        header('Location: ventas.php');
        exit();
    }
}

// Obtener todas las ventas
$ventas = obtenerVentas($conexion);


require_once 'header_footer/header.php';
?>


    <!-- Contenido de la página -->

    <h1>Ventas</h1>

    <p>Captura los datos sobre la venta.</p>

    <form method="POST" action="ventas.php">
        <label for="producto">Producto:</label>
        <select name="producto" id="producto" required>
            <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
            <?php foreach ($productosDisponibles as $producto) { ?>
                <option value="<?php echo $producto['id_producto']; ?>"><?php echo $producto['nombre_producto']; ?></option>
            <?php } ?>
        </select><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad..." required><br>

        <label for="cliente">Cliente:</label>
        <select name="cliente" id="cliente" required>
            <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombre_cliente'] . ' - ' . $cliente['telefono_cliente']; ?></option>
            <?php } ?>
        </select><br>

        <label for="empleado">Empleado:</label>
        <select name="empleado" id="empleado" required>
            <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
            <?php foreach ($empleados as $empleado) { ?>
                <option value="<?php echo $empleado['rfc']; ?>"><?php echo $empleado['nombre_empleado']; ?></option>
            <?php } ?>
        </select><br>

        <input type="submit" value="Vender">
    </form>

    <h2>Lista de Ventas</h2>
    <table>
        <tr>
            <th>ID Venta</th>
            <th>Fecha de venta</th>
            <th>Producto</th>
            <th>Cliente</th>
            <th>Empleado</th>
            <th>Cantidad comprada</th>
            <th>Total Venta</th>
        </tr>
        <?php foreach ($ventas as $venta) { ?>
            <tr>
                <td><?php echo $venta['id_venta']; ?></td>
                <td><?php echo $venta['fecha_venta']; ?></td>
                <td><?php echo $venta['nombre_producto']; ?></td>
                <td><?php echo obtenerNombreCliente($venta['id_cliente'], $conexion); ?></td>
                <td><?php echo $venta['rfc_empleado'] ." - ". obtenerNombreEmpleado($venta['rfc_empleado'], $conexion); ?></td>
                <td><?php echo $venta['cantidad_comprada']?></td>
                <td><?php echo $venta['total_venta']; ?></td>
            </tr>
        <?php } ?>
    </table>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
