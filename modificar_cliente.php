<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion/conexion.php';
// Incluir el archivo de funciones
require_once 'funciones/funciones.php';

// Verificar si se envió el formulario de modificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = $_POST['id_cliente'];
    $nombreCliente = $_POST['nombre_cliente'];
    $direccionCliente = $_POST['direccion_cliente'];
    $telefonoCliente = $_POST['telefono_cliente'];

    // Validar el formulario
    if (validarFormularioClientes($nombreCliente, $direccionCliente, $telefonoCliente)) {
        actualizarCliente($idCliente, $nombreCliente, $direccionCliente, $telefonoCliente, $conexion);
        header('Location: clientes.php');
        exit();
    } else {
        echo '<script>alert("Los campos contienen caracteres no permitidos o el teléfono no es válido");</script>';
    }
}

// Obtener el ID del cliente a modificar
if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];
    $cliente = obtenerClientePorID($idCliente, $conexion);
    if (!$cliente) {
        echo 'Cliente no encontrado';
        exit();
    }
} else {
    echo 'ID de cliente no especificado';
    exit();
}


require_once 'header_footer/header.php';
?>

    <h1>Modificar Cliente</h1>

    <p>Por favor modifica los datos del cliente.</p>

    <form method="POST" action="modificar_cliente.php">
        <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">

        <label for="nombre_cliente">Nombre:</label>
        <input type="text" name="nombre_cliente" id="nombre_cliente" maxlength="50" value="<?php echo $cliente['nombre_cliente']; ?>" placeholder="Ingresa un nombre..." required><br>

        <label for="direccion_cliente">Dirección:</label>
        <textarea name="direccion_cliente" id="direccion_cliente" maxlength="60" placeholder="Ingresa una dirección..." required><?php echo $cliente['direccion_cliente']; ?></textarea><br>

        <label for="telefono_cliente">Teléfono:</label>
        <input type="number" name="telefono_cliente" id="telefono_cliente" minlength="10" maxlength="10" value="<?php echo $cliente['telefono_cliente']; ?>" placeholder="10 dígitos..." required><br>

        <input type="submit" value="Actualizar">
        <input type="submit" href="clientes.php" value="Cancelar">
    </form>

<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>