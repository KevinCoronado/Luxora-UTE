<?php
include 'conexion.php';

// Obtener el ID del usuario (RECORDATORIOOOOOO  CAMBIAR POR EL ID DE SESSION)
$id_usuario = 1;

$query = "SELECT Compras.*, Articulos.Nombre_articulo, Articulos.Imagen, 
                 Usuarios.Calle, Usuarios.Colonia, Usuarios.Municipio, Usuarios.Estado, Usuarios.CP 
          FROM Compras 
          JOIN Articulos ON Compras.Id_articulo = Articulos.Id_articulo 
          JOIN Usuarios ON Compras.Id_usuario = Usuarios.Id_usuario
          WHERE Compras.Id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$compras = [];

while ($row = $result->fetch_assoc()) {
    $compras[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($compras);
?>