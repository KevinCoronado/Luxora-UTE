<?php
include "conexion.php";

// Consultar todos los productos
$sql = "SELECT Id_articulo, Nombre_articulo, Descripcion, Precio, Disponibilidad, Imagen, Marca FROM Articulos 
        WHERE Estado_activo = TRUE";
$result = $conn->query($sql);

$articulos = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articulos[] = $row;
    }
}

// Devolver los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($articulos);

$conn->close();
?>