<?php
require_once 'conexion/conexion.php';

require_once 'header_footer/header.php';
?>

<h1>Mostrar todos los clientes que vivan en una región.</h1>

<form method="POST" action="">
  <label for="region">Región:</label>
  <input type="text" name="region" id="region" placeholder="CDMX, ESTADO DE MEXICO..." required>
  <button type="submit">Buscar</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $region = $_POST["region"];

  $stmt = $conexion->prepare("SELECT id_cliente, nombre_cliente, direccion_cliente, telefono_cliente
                             FROM tbl_clientes
                             WHERE direccion_cliente LIKE :region");
  $stmt->bindValue(':region', '%' . $region . '%');
  $stmt->execute();
  $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (count($clientes) > 0) {
    echo '<h2>Resultados de la búsqueda</h2>';
    echo '<table>';
    echo '<tr><th>ID Cliente</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th></tr>';
    foreach ($clientes as $cliente) {
      echo '<tr>';
      echo '<td>' . $cliente['id_cliente'] . '</td>';
      echo '<td>' . $cliente['nombre_cliente'] . '</td>';
      echo '<td>' . $cliente['direccion_cliente'] . '</td>';
      echo '<td>' . $cliente['telefono_cliente'] . '</td>';
      echo '</tr>';
    }
    echo '</table>';
  } else {
    echo '<script>alert("No existen clientes en la región especificada.");</script>';
  }
}
?>


<?php
require_once 'header_footer/footer.php';
?>
</body>
</html>
