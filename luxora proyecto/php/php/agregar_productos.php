<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recibimos los datos
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $marca = $_POST['marca'];
    $disponibilidad = $_POST['disponibilidad'];
    $precio = $_POST['precio'];

    // Manejo de la subida de la imagen
    $imagen = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    
    //Donde se va a guardar la imagen
    $carpeta_destino = 'D:\Xampp\htdocs\luxora proyecto\imagenes-productos';
    $ruta_imagen = ($carpeta_destino .'/'.$imagen);

    //Este dato se guarda en mysql
    $ruta= 'imagenes-productos/'.$imagen;
    

    // Mover la imagen a la carpeta destino
    if (move_uploaded_file($imagen_temp, $ruta_imagen)) {

        // Insertar los datos en la base de datos
        $sql = "INSERT INTO Articulos (Nombre_articulo, Descripcion, Precio, Disponibilidad, Imagen, Marca, Estado_activo) 
                VALUES ('$nombre', '$descripcion', '$precio', '$disponibilidad', '$ruta', '$marca', TRUE)";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Articulo agregado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar el articulo']);
        }

        
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el articulo']);
    }
}
$conn->close();
?>
