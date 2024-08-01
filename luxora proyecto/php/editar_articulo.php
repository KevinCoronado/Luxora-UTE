<?php
include "conexion.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recibimos los datos
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $marca = $_POST['marca'];
    $disponibilidad = $_POST['disponibilidad'];
    $precio = $_POST['precio'];

    // Manejo de la subida de la imagen
    $imagen = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    
    //Aqui es donde se va a subir la imagen
    $carpeta_destino = 'D:\Xampp\htdocs\luxora proyecto\imagenes-productos';
    $ruta_imagen = ($carpeta_destino .'/'.$imagen);
    $ruta= 'imagenes-productos/'.$imagen;

    // Mover la imagen a la carpeta destino
    if (move_uploaded_file($imagen_temp, $ruta_imagen)) {

        // Insertar los datos en la base de datos
        $sql = "UPDATE Articulos SET Nombre_articulo = '$nombre', Descripcion = '$descripcion',
        Precio = '$precio',Disponibilidad = '$disponibilidad', Imagen = '$ruta', Marca = '$marca'
         WHERE Id_articulo = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Articulo actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el articulo']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el articulo']);
    }
}
$conn->close();
?>
