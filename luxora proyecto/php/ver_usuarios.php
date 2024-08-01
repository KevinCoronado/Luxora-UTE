<?php
include "conexion.php";
//Selecciona todos los usuarios
$sql = "SELECT Id_usuario,Nombre_usuario, Email, Rol FROM Usuarios";
$result = $conn->query($sql);

$usuarios = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
//Los devuelve en un json
echo json_encode($usuarios);

$conn->close();
?>