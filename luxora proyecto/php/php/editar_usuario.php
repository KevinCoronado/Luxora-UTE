<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Obtenemos los datos de un json
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];
    $nombre = $data['nombre'];
    $correo = $data['correo'];
    $rol = $data['rol'];


    //El Update
    $stmt = $conn->prepare("UPDATE Usuarios SET Nombre_usuario = '$nombre', Email = '$correo',
                            rol = '$rol' WHERE Id_usuario = ?");

    //Aqui se declara que el parametro es un Integer
    $stmt->bind_param("i", $id);
    //Se ejecuta el SQL
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Usuario actualizado con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario']);
    }
    $stmt->close();
}
$conn->close();
?>