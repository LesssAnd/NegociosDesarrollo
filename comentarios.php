<?php

// Conexión a base de datos
$id_producto = $_GET['id'];
$host = '127.0.0.1';
$usuario = 'root'; 
$clave = 'abcd1234';
$nombreBD = 'productos'; 

// Realiza la conexión y consulta a la base de datos para obtener los detalles del producto
$conexion = new mysqli($host, $usuario, $clave, $nombreBD);
$sqlProducto = "SELECT nombre_producto, descripcion FROM productos WHERE id_producto = $id_producto";
$sqlComentarios = "SELECT c.comentario, c.nombre_usuario, c.fecha_comentario
                 FROM comentarios c
                 INNER JOIN productos p ON c.id_producto = p.id_producto
                 WHERE p.id_producto = $id_producto";

$resultadoProducto = $conexion->query($sqlProducto);
$resultadoComentarios = $conexion->query($sqlComentarios);

// Cerrar la conexión
$conexion->close();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Agrega el enlace a tu archivo CSS para los estilos -->
</head>
<body>

<?php
if ($resultadoProducto->num_rows > 0) {
    $detalle_producto = $resultadoProducto->fetch_assoc();
    $nombre_producto = $detalle_producto['nombre_producto'];
    $descripcion_producto = $detalle_producto['descripcion'];

    // Mostrar detalles del producto
?>
    <h2 class="product-name"><?php echo $nombre_producto; ?></h2>
    <img class="product-image" src="imgs/<?php echo $id_producto; ?>.png" alt="Producto <?php echo $id_producto; ?>">
<?php
} else {
    echo 'Producto no encontrado.';
}
?>

<div id="formulario-comentario" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 15px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); z-index: 9999;">
    <button onclick="ocultarFormulario()" style="position: absolute; top: 10px; right: 10px; cursor: pointer;">Cerrar</button>
    <form action="procesar_comentario.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="opciones">Selecciona una opción:</label>
        <select name="opciones" required>
            <option value="1">Bloqueador solar Nivea</option>
            <option value="2">Crema corporal St Ives</option>
            <option value="3">Jabon Dove</option>
            <option value="4">Crema CeraVe</option>
            <option value="5">Locion Cetaphil</option>
            <option value="6">Opcion 6</option>
        </select>
        
          <br>
        <label for="comentario">Comentario:</label>
        <textarea name="comentario" rows="4" required></textarea>

        <input type="submit" value="Enviar Comentario">
    </form>
</div>

<script>
    function mostrarFormulario() {
        var formulario = document.getElementById("formulario-comentario");
        formulario.style.display = "block";
    }

    function ocultarFormulario() {
        var formulario = document.getElementById("formulario-comentario");
        formulario.style.display = "none";
    }
</script>

<?php
// Mostrar el carrusel de comentarios
echo '<div class="carousel-coments">';
if ($resultadoComentarios->num_rows > 0) {
    while ($row = $resultadoComentarios->fetch_assoc()) {
        echo '<div class="carousel-item-coments">';
        
        echo '<p class="user-content">' . (isset($row["nombre_usuario"]) ? $row["nombre_usuario"] : '') . ' : </p>';
        echo '<p class="comment-content">' . (isset($row["comentario"]) ? $row["comentario"] : '') . '</p>';
        echo '<p class="comment-date">' . (isset($row["fecha_comentario"]) ? $row["fecha_comentario"] : '') . '</p>';
        
        echo '</div>';
    }
} else {
    echo '<div class="no-comments-message">No hay comentarios para mostrar.</div>';
}
echo '</div>';
?>

</body>
</html>
