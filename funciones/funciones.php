<?php

//Página de Empleados

// Función para verificar si ya existe un registro con el mismo RFC
function verificarRFC($rfc, $conexion) {
    $consulta = $conexion->prepare("SELECT COUNT(*) FROM tbl_empleados WHERE rfc = :rfc");
    $consulta->bindParam(':rfc', $rfc);
    $consulta->execute();
    $count = $consulta->fetchColumn();
    return $count > 0;
}

// Función para insertar un nuevo empleado en la base de datos
function insertarEmpleado($rfc, $nombre, $genero, $conexion) {
    $insertar = $conexion->prepare("INSERT INTO tbl_empleados (rfc, nombre_empleado, genero) VALUES (:rfc, :nombre, :genero)");
    $insertar->bindParam(':rfc', $rfc);
    $insertar->bindParam(':nombre', $nombre);
    $insertar->bindParam(':genero', $genero);
    $insertar->execute();
}

// Función para obtener todos los empleados de la base de datos
function obtenerEmpleados($conexion) {
    $consulta = $conexion->query("SELECT * FROM tbl_empleados");
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

// Función para eliminar un empleado de la base de datos por su ID
function eliminarEmpleado($id, $conexion) {
    // Verificar si existen registros en tbl_ventas relacionados con el empleado
    $consultaVentas = $conexion->prepare("SELECT COUNT(*) FROM tbl_ventas WHERE rfc_empleado = :id");
    $consultaVentas->bindParam(':id', $id);
    $consultaVentas->execute();
    $countVentas = $consultaVentas->fetchColumn();

    // Si existen registros en tbl_ventas, mostrar una alerta de error y no eliminar el empleado
    if ($countVentas > 0) {
        echo "<script>alert('No se puede eliminar el empleado porque tiene ventas asociadas.');</script>";
        return;
    }

    // Si no hay registros en tbl_ventas, eliminar el empleado
    $eliminar = $conexion->prepare("DELETE FROM tbl_empleados WHERE rfc = :rfc");
    $eliminar->bindParam(':rfc', $id);
    $eliminar->execute();
}

// Función para obtener un empleado por su RFC
function obtenerEmpleadoPorRFC($rfc, $conexion) {
    $consulta = $conexion->prepare("SELECT * FROM tbl_empleados WHERE rfc = :rfc");
    $consulta->bindParam(':rfc', $rfc);
    $consulta->execute();
    return $consulta->fetch(PDO::FETCH_ASSOC);
}

// Función para actualizar los datos de un empleado en la base de datos
function actualizarEmpleado($rfc, $nuevoRFC, $nombre, $genero, $conexion) {
    $actualizar = $conexion->prepare("UPDATE tbl_empleados SET rfc = :nuevoRFC, nombre_empleado = :nombre, genero = :genero WHERE rfc = :rfc");
    $actualizar->bindParam(':nuevoRFC', $nuevoRFC);
    $actualizar->bindParam(':nombre', $nombre);
    $actualizar->bindParam(':genero', $genero);
    $actualizar->bindParam(':rfc', $rfc);
    $actualizar->execute();
}

//Página de Clientes

function validarTelefonoUnico($telefono, $conexion)
{
    $query = "SELECT COUNT(*) as total FROM tbl_clientes WHERE telefono_cliente = :telefono";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':telefono', $telefono);
    $statement->execute();
    $resultado = $statement->fetch(PDO::FETCH_ASSOC);

    return $resultado['total'] == 0;
}

// Función para validar los datos del formulario de clientes
function validarFormularioClientes($nombre, $direccion, $telefono) {
    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($direccion) || empty($telefono)) {
        return false;
    }

    // Validar que el teléfono sea válido (10 dígitos numéricos)
    if (!preg_match('/^\d{10}$/', $telefono)) {
        return false;
    }

    // Puedes agregar más validaciones según tus requisitos

    return true;
}

// Función para insertar un nuevo cliente en la base de datos
function insertarCliente($nombre, $direccion, $telefono, $conexion) {
    $insertar = $conexion->prepare("INSERT INTO tbl_clientes (nombre_cliente, direccion_cliente, telefono_cliente) VALUES (:nombre, :direccion, :telefono)");
    $insertar->bindParam(':nombre', $nombre);
    $insertar->bindParam(':direccion', $direccion);
    $insertar->bindParam(':telefono', $telefono);
    $insertar->execute();
}

// Función para obtener todos los clientes de la base de datos
function obtenerClientes($conexion) {
    $consulta = $conexion->query("SELECT * FROM tbl_clientes");
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

// Función para eliminar un cliente de la base de datos por su ID
function eliminarCliente($id, $conexion) {
    // Verificar si existen registros en tbl_ventas relacionados con el cliente
    $consultaVentas = $conexion->prepare("SELECT COUNT(*) FROM tbl_ventas WHERE id_cliente = :id");
    $consultaVentas->bindParam(':id', $id);
    $consultaVentas->execute();
    $countVentas = $consultaVentas->fetchColumn();

    // Si existen registros en tbl_ventas, mostrar una alerta de error y no eliminar el cliente
    if ($countVentas > 0) {
        echo "<script>alert('No se puede eliminar el cliente porque tiene ventas asociadas.');</script>";
        return;
    }

    // Si no hay registros en tbl_ventas, eliminar el cliente
    $eliminar = $conexion->prepare("DELETE FROM tbl_clientes WHERE id_cliente = :id");
    $eliminar->bindParam(':id', $id);
    $eliminar->execute();
}

// Función para obtener un cliente por su ID
function obtenerClientePorID($id, $conexion) {
    $consulta = $conexion->prepare("SELECT * FROM tbl_clientes WHERE id_cliente = :id");
    $consulta->bindParam(':id', $id);
    $consulta->execute();
    return $consulta->fetch(PDO::FETCH_ASSOC);
}

// Función para actualizar los datos de un cliente en la base de datos
function actualizarCliente($id, $nombre, $direccion, $telefono, $conexion) {
    $actualizar = $conexion->prepare("UPDATE tbl_clientes SET nombre_cliente = :nombre, direccion_cliente = :direccion, telefono_cliente = :telefono WHERE id_cliente = :id");
    $actualizar->bindParam(':nombre', $nombre);
    $actualizar->bindParam(':direccion', $direccion);
    $actualizar->bindParam(':telefono', $telefono);
    $actualizar->bindParam(':id', $id);
    $actualizar->execute();
}

//Página de Productos

// Función para validar los datos del formulario de productos
function validarFormularioProductos($proveedor, $categoria, $nombre, $descripcion, $precioUnitario, $cantidadStock) {
    // Validar que los campos no estén vacíos
    if (empty($proveedor) || empty($categoria) || empty($nombre) || empty($descripcion) || empty($precioUnitario) || empty($cantidadStock)) {
        return false;
    }

    // Validar que el precio unitario sea un número válido
    if (!is_numeric($precioUnitario)) {
        return false;
    }

    // Validar que la cantidad en stock sea un número válido
    if (!is_numeric($cantidadStock)) {
        return false;
    }

    // Puedes agregar más validaciones según tus requisitos

    return true;
}


// Función para insertar un nuevo producto en la base de datos
function insertarProducto($fechaCompra, $proveedor, $categoria, $nombre, $descripcion, $precioUnitario, $cantidadStock, $conexion) {
    $insertar = $conexion->prepare("INSERT INTO tbl_productos (fecha_compra, proveedor, categoria, nombre_producto, descripcion_producto, precio_unitario, cantidad_stock) VALUES (:fecha_compra, :proveedor, :categoria, :nombre, :descripcion, :precioUnitario, :cantidadStock)");
    $insertar->bindParam(':fecha_compra', $fechaCompra);
    $insertar->bindParam(':proveedor', $proveedor);
    $insertar->bindParam(':categoria', $categoria);
    $insertar->bindParam(':nombre', $nombre);
    $insertar->bindParam(':descripcion', $descripcion);
    $insertar->bindParam(':precioUnitario', $precioUnitario);
    $insertar->bindParam(':cantidadStock', $cantidadStock);
    $insertar->execute();
}

// Función para obtener todos los productos de la base de datos
function obtenerProductos($conexion) {
    $consulta = $conexion->query("SELECT * FROM tbl_productos");
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

// Función para eliminar un producto de la base de datos por su ID
function eliminarProducto($idProducto, $conexion) {
    // Eliminar registros de tbl_productos_venta relacionados con el producto
    $sqlEliminarVentas = "DELETE FROM tbl_productos_venta WHERE id_producto = :idProducto";
    $stmtEliminarVentas = $conexion->prepare($sqlEliminarVentas);
    $stmtEliminarVentas->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
    $stmtEliminarVentas->execute();

    // Eliminar el producto
    $sqlEliminarProducto = "DELETE FROM tbl_productos WHERE id_producto = :idProducto";
    $stmtEliminarProducto = $conexion->prepare($sqlEliminarProducto);
    $stmtEliminarProducto->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
    $stmtEliminarProducto->execute();
}

// Función para obtener un producto por su ID
function obtenerProductoPorID($id, $conexion) {
    $consulta = $conexion->prepare("SELECT * FROM tbl_productos WHERE id_producto = :id");
    $consulta->bindParam(':id', $id);
    $consulta->execute();
    return $consulta->fetch(PDO::FETCH_ASSOC);
}

// Función para actualizar los datos de un producto en la base de datos
function actualizarProducto($id, $proveedor, $categoria, $nombre, $descripcion, $precioUnitario, $cantidadStock, $conexion) {
    $actualizar = $conexion->prepare("UPDATE tbl_productos SET proveedor = :proveedor, categoria = :categoria, nombre_producto = :nombre, descripcion_producto = :descripcion, precio_unitario = :precioUnitario, cantidad_stock = :cantidadStock WHERE id_producto = :id");
    $actualizar->bindParam(':proveedor', $proveedor);
    $actualizar->bindParam(':categoria', $categoria);
    $actualizar->bindParam(':nombre', $nombre);
    $actualizar->bindParam(':descripcion', $descripcion);
    $actualizar->bindParam(':precioUnitario', $precioUnitario);
    $actualizar->bindParam(':cantidadStock', $cantidadStock);
    $actualizar->bindParam(':id', $id);
    $actualizar->execute();
}

//Página de Ventas

function obtenerProductosDisponibles($conexion)
{
    $query = "SELECT id_producto, nombre_producto, cantidad_stock FROM tbl_productos WHERE cantidad_stock > 0";
    $statement = $conexion->query($query);
    $productos = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $productos;
}

// Función para obtener la cantidad en stock de un producto
function obtenerCantidadStock($idProducto, $conexion) {
    $query = "SELECT cantidad_stock FROM tbl_productos WHERE id_producto = :id_producto";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':id_producto', $idProducto);
    $statement->execute();
    $producto = $statement->fetch(PDO::FETCH_ASSOC);
    return $producto['cantidad_stock'];
}

// Función para insertar una venta en la tabla de ventas
function insertarVenta($fechaVenta, $idCliente, $rfcEmpleado, $totalVenta, $conexion) {
    $query = "INSERT INTO tbl_ventas (fecha_venta, id_cliente, rfc_empleado, total_venta) VALUES (:fecha_venta, :id_cliente, :rfc_empleado, :total_venta)";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':fecha_venta', $fechaVenta);
    $statement->bindParam(':id_cliente', $idCliente);
    $statement->bindParam(':rfc_empleado', $rfcEmpleado);
    $statement->bindParam(':total_venta', $totalVenta);
    $statement->execute();
    return $conexion->lastInsertId();
}

// Función para insertar un producto vendido en la tabla de productos_venta
function insertarProductoVenta($idVenta, $idProducto, $cantidadComprada, $conexion) {
    $query = "INSERT INTO tbl_productos_venta (id_venta, id_producto, cantidad_comprada) VALUES (:id_venta, :id_producto, :cantidad_comprada)";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':id_venta', $idVenta);
    $statement->bindParam(':id_producto', $idProducto);
    $statement->bindParam(':cantidad_comprada', $cantidadComprada);
    $statement->execute();
}

// Función para actualizar la cantidad en stock de un producto
function actualizarCantidadStock($idProducto, $cantidadComprada, $conexion) {
    $query = "UPDATE tbl_productos SET cantidad_stock = cantidad_stock - :cantidad_comprada WHERE id_producto = :id_producto";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':cantidad_comprada', $cantidadComprada);
    $statement->bindParam(':id_producto', $idProducto);
    $statement->execute();
}

// Obtener todas las ventas con el nombre del producto y cantidad comprada
function obtenerVentas($conexion) {
    $sql = "SELECT v.id_venta, v.fecha_venta, p.nombre_producto, pv.cantidad_comprada, v.id_cliente, v.rfc_empleado, v.total_venta
            FROM tbl_ventas v
            INNER JOIN tbl_productos_venta pv ON v.id_venta = pv.id_venta
            INNER JOIN tbl_productos p ON pv.id_producto = p.id_producto";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

// Función para obtener el nombre de un cliente por su ID
function obtenerNombreCliente($idCliente, $conexion) {
    $query = "SELECT nombre_cliente FROM tbl_clientes WHERE id_cliente = :id_cliente";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':id_cliente', $idCliente);
    $statement->execute();
    $cliente = $statement->fetch(PDO::FETCH_ASSOC);
    return $cliente['nombre_cliente'];
}

// Función para obtener el nombre de un empleado por su RFC
function obtenerNombreEmpleado($rfcEmpleado, $conexion) {
    $query = "SELECT nombre_empleado FROM tbl_empleados WHERE rfc = :rfc_empleado";
    $statement = $conexion->prepare($query);
    $statement->bindParam(':rfc_empleado', $rfcEmpleado);
    $statement->execute();
    $empleado = $statement->fetch(PDO::FETCH_ASSOC);
    return $empleado['nombre_empleado'];
}

// Obtener el nombre del producto por su ID
function obtenerNombreProducto($idProducto, $conexion) {
    $sql = "SELECT nombre_producto FROM tbl_productos WHERE id_producto = :idProducto";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado['nombre_producto'];
}
?>