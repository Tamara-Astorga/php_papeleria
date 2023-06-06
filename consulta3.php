<?php
require_once 'conexion/conexion.php';

require_once 'header_footer/header.php';
?>

<h1>Mostrar todos los empleados por género.</h1>

<form method="POST" action="">
  <label for="genero">Género:</label>
  <select name="genero" id="genero">
    <option selected="true" disabled="disabled" value="">Selecciona una opción</option>
    <option value="Masculino">Masculino</option>
    <option value="Femenino">Femenino</option>
  </select>
  <button type="submit">Buscar</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $genero = $_POST["genero"];

  $stmt = $conexion->prepare("SELECT rfc, nombre_empleado, genero
                             FROM tbl_empleados
                             WHERE genero = :genero");
  $stmt->bindValue(':genero', $genero);
  $stmt->execute();
  $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo '<h2>Resultados de la búsqueda</h2>';
  echo '<table>';
  echo '<tr><th>RFC</th><th>Nombre</th><th>Género</th></tr>';
  foreach ($empleados as $empleado) {
    echo '<tr>';
    echo '<td>' . $empleado['rfc'] . '</td>';
    echo '<td>' . $empleado['nombre_empleado'] . '</td>';
    echo '<td>' . $empleado['genero'] . '</td>';
    echo '</tr>';
  }
  echo '</table>';
}
?>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
