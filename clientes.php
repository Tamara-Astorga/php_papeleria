<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion/conexion.php';
// Incluir el archivo de funciones
require_once 'funciones/funciones.php';

// Insertar datos en la base de datos cuando se envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreCliente = $_POST['nombre_cliente'];
    $direccionCliente = $_POST['direccion_cliente'];
    $telefonoCliente = $_POST['telefono_cliente'];

    // Validar el formulario
    if (validarFormularioClientes($nombreCliente, $direccionCliente, $telefonoCliente)) {
        if (validarTelefonoUnico($telefonoCliente, $conexion)) {
            insertarCliente($nombreCliente, $direccionCliente, $telefonoCliente, $conexion);
        } else {
            echo '<script>alert("El teléfono ya está registrado. Por favor, intenta con otro.");</script>';
        }
    } else {
        echo '<script>alert("Los campos contienen caracteres no permitidos o el teléfono no es válido");</script>';
    }
}

if (isset($_GET['eliminar'])) {
    $idCliente = $_GET['eliminar'];
    eliminarCliente($idCliente, $conexion);
    // Redirigir a la página actual para evitar reenviar la solicitud de eliminación al actualizar la página
    echo '<script> window.location.href = "clientes.php";</script>';
    exit;
}


// Obtener los registros de la tabla tbl_clientes
$clientes = obtenerClientes($conexion);


require_once 'header_footer/header.php';
?>

    <!-- Contenido de la página -->

    <h1>Clientes</h1>

    <p>Captura los datos del cliente.</p>
    
    <form method="POST" action="clientes.php">
        <label for="nombre_cliente">Nombre:</label>
        <input type="text" name="nombre_cliente" id="nombre_cliente" maxlength="50" placeholder="Ingresa un nombre..." required><br>

        <label for="direccion_cliente">Dirección:</label>
        <textarea name="direccion_cliente" id="direccion_cliente" maxlength="60" placeholder="Ingresa una dirección..." required></textarea><br>

        <label for="telefono_cliente">Teléfono:</label>
        <input type="number" name="telefono_cliente" id="telefono_cliente" minlength="10" maxength="10" placeholder="10 dígitos..." required><br>

        <input type="submit" value="Insertar">
    </form>

    <h2>Registros de Clientes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?php echo $cliente['id_cliente']; ?></td>
            <td><?php echo $cliente['nombre_cliente']; ?></td>
            <td><?php echo $cliente['direccion_cliente']; ?></td>
            <td><?php echo $cliente['telefono_cliente']; ?></td>
            <td>
                <a href="clientes.php?eliminar=<?php echo $cliente['id_cliente']; ?>">Eliminar</a>
                <a href="modificar_cliente.php?id=<?php echo $cliente['id_cliente']; ?>">Modificar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
