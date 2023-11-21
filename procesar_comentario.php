<?php
var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre_usuario = $_POST['nombre'];
    $id_producto = $_POST['opciones'];  // Aquí asumo que el valor de opciones es el id_producto
    $comentario = $_POST['comentario'];
    $sexo = $_POST['sexo'];

    // Conexión a la base de datos
    $host = '127.0.0.1';
    $usuario = 'root'; 
    $clave = 'abcd1234';
    $nombreBD = 'productos'; 

    $conexion = new mysqli($host, $usuario, $clave, $nombreBD);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión a la base de datos: " . $conexion->connect_error);
    }

    // Insertar el comentario en la base de datos
    $sqlInsertarComentario = "INSERT INTO comentarios (nombre_usuario, id_producto, comentario,sexo) VALUES ('$nombre_usuario', '$id_producto', '$comentario', '$sexo')";


    if ($conexion->query($sqlInsertarComentario) === TRUE) {
            // Comentario agregado correctamente
            $mensaje = "Comentario agregado correctamente";
        } else {
            // Error al agregar comentario
            $mensaje = "Error al agregar comentario: " . $conexion->error;
        }

        // Cerrar la conexión
        $conexion->close();

        // Redirigir después de procesar el formulario
        header("Location: index.html");
        exit();
    /*
    if ($conexion->query($sqlInsertarComentario) === TRUE) {
        // Comentario agregado correctamente
        $mensaje = "Comentario agregado correctamente";
    } else {
        // Error al agregar comentario
        $mensaje = "Error al agregar comentario: " . $conexion->error;
    }
    
    $mensajeJS = str_replace('"', '\"', $mensaje);  // Escapar comillas para evitar problemas en el script

    echo '<script>';
    echo 'alert("' . $mensajeJS . '");';
    echo 'window.location.href = "index.html";';
    echo '</script>';

    // Cerrar la conexión
    $conexion->close();
    */

}
else {
    echo "Algo salio mal";
}
?>
