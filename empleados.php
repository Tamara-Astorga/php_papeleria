<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion/conexion.php';
// Incluir el archivo de funciones
require_once 'funciones/funciones.php';

// Insertar datos en la base de datos cuando se envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rfc = $_POST['rfc'];
    $nombre = $_POST['nombre'];
    $genero = $_POST['genero'];

    // Verificar si el RFC ya existe
    if (verificarRFC($rfc, $conexion)) {
        echo "<script>alert('El RFC " . $rfc . " ya está registrado, agrega otro o modifícalo');</script>";
    } else {
        insertarEmpleado($rfc, $nombre, $genero, $conexion);
    }
}

if (isset($_GET['eliminar'])) {
    $rfcEliminar = $_GET['eliminar'];
    eliminarEmpleado($rfcEliminar, $conexion);
    // Redirigir a la página actual para evitar reenviar la solicitud de eliminación al actualizar la página
    echo '<script> window.location.href = "empleados.php";</script>';
    exit;
}

// Obtener los registros de la tabla tbl_empleados
$empleados = obtenerEmpleados($conexion);


require_once 'header_footer/header.php';
?>

    <!-- Contenido de la página -->

    <h1>Empleados</h1>

    <p>Captura los datos del empleado.</p>

    <form method="POST" action="empleados.php">
        <label for="rfc">RFC:</label>
        <input type="text" name="rfc" id="rfc" maxlength="13" placeholder="Ingresa un RFC..." required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" maxlength="30" placeholder="Ingresa un nombre..." required><br>

        <label for="genero">Género:</label>
        <select name="genero" id="genero" required>
            <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
        </select><br>

        <input type="submit" value="Insertar">
    </form>

    <h2>Registros de Empleados</h2>
    <table>
        <tr>
            <th>RFC</th>
            <th>Nombre</th>
            <th>Género</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($empleados as $empleado): ?>
        <tr>
            <td><?php echo $empleado['rfc']; ?></td>
            <td><?php echo $empleado['nombre_empleado']; ?></td>
            <td><?php echo $empleado['genero']; ?></td>
            <td>
                <a href="empleados.php?eliminar=<?php echo $empleado['rfc']; ?>">Eliminar</a>
                <a href="modificar_empleado.php?rfc=<?php echo $empleado['rfc']; ?>">Modificar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
