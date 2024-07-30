<?php
include "conexion.php";

$sql = "SELECT Id_usuario,Nombre_usuario, Email, Rol FROM Usuarios";
$result = $conn->query($sql);

$usuarios = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

echo json_encode($usuarios);

$conn->close();
?>