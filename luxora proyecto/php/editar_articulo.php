<?php
include "conexion.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $marca = $_POST['marca'];
    $disponibilidad = $_POST['disponibilidad'];
    $precio = $_POST['precio'];

    // Manejo de la subida de la imagen
    $imagen = isset($_FILES['imagen']) ? $_FILES['imagen']['name'] : '';
    $imagen_temp = isset($_FILES['imagen']) ? $_FILES['imagen']['tmp_name'] : '';

    // Carpeta destino para subir la imagen
    $carpeta_destino = 'D:\Xampp\htdocs\luxora proyecto\imagenes-productos';
    $ruta_imagen = ($carpeta_destino .'/'.$imagen);
    $ruta = 'imagenes-productos/'.$imagen;

    // Construir la consulta SQL
    if (!empty($imagen)) {
        // Si se sube una nueva imagen
        if (move_uploaded_file($imagen_temp, $ruta_imagen)) {
            $sql = "UPDATE Articulos SET Nombre_articulo = '$nombre', Descripcion = '$descripcion',
                    Precio = '$precio', Disponibilidad = '$disponibilidad', Imagen = '$ruta', Marca = '$marca'
                    WHERE Id_articulo = '$id'";
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
            exit;
        }
    } else {
        // Si no se sube una nueva imagen
        $sql = "UPDATE Articulos SET Nombre_articulo = '$nombre', Descripcion = '$descripcion',
                Precio = '$precio', Disponibilidad = '$disponibilidad', Marca = '$marca'
                WHERE Id_articulo = '$id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Articulo actualizado exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el articulo']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
}
$conn->close();
?>


