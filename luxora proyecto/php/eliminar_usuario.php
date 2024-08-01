<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Se reciben los datos del json
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    //Se prepara el delete, stmt almacena el resultado del metodo
    $stmt = $conn->prepare("DELETE FROM Usuarios WHERE Id_usuario = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Usuario eliminado con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario']);
    }
    $stmt->close();
}
$conn->close();
?>

