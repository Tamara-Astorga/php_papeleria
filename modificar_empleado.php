<?php
// Incluir el archivo de conexión a la base de datos
require_once 'conexion/conexion.php';
// Incluir el archivo de funciones
require_once 'funciones/funciones.php';

// Obtener el RFC del empleado a modificar
if (isset($_GET['rfc'])) {
    $rfc = $_GET['rfc'];

    // Obtener los datos del empleado
    $empleado = obtenerEmpleadoPorRFC($rfc, $conexion);

    if (!$empleado) {
        echo 'El empleado no existe.';
        exit;
    }
} else {
    echo 'No se ha especificado un RFC.';
    exit;
}

// Actualizar los datos del empleado cuando se envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoRFC = $_POST['rfc'];
    $nombre = $_POST['nombre'];
    $genero = $_POST['genero'];

    // Verificar si el nuevo RFC ya existe
    if ($nuevoRFC !== $rfc && verificarRFC($nuevoRFC, $conexion)) {
        echo "<script>alert('El RFC " . $nuevoRFC . " ya está registrado, agrega otro o modifícalo');</script>";
    } else {
        actualizarEmpleado($rfc, $nuevoRFC, $nombre, $genero, $conexion);
        header('Location: empleados.php');
        exit;
    }
}


require_once 'header_footer/header.php';
?>
    <!-- Contenido de la página -->

    <h1>Modificar empleado</h1>
    <p>Por favor modifica los datos del empleado.</p>

    <form method="POST" action="modificar_empleado.php?rfc=<?php echo $empleado['rfc']; ?>">
        <label for="rfc">RFC:</label>
        <input type="text" name="rfc" id="rfc" value="<?php echo $empleado['rfc']; ?>" maxlength="13" placeholder="Ingresa un RFC..." required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $empleado['nombre_empleado']; ?>" maxlength="30" placeholder="Ingresa un nombre..." required><br>

        <label for="genero">Género:</label>
        <select name="genero" id="genero" required>
            <option value="Masculino" <?php if ($empleado['genero'] === 'Masculino') echo 'selected'; ?>>Masculino</option>
            <option value="Femenino" <?php if ($empleado['genero'] === 'Femenino') echo 'selected'; ?>>Femenino</option>
        </select><br>

        <input type="submit" value="Actualizar">
        <input type="submit" href="empleados.php" value="Cancelar">
    </form>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
