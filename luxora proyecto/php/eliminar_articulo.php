<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Obtenemos los datos de un json
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'];

    //Se prepara el delete
    $stmt = $conn->prepare("DELETE FROM Articulos WHERE Id_articulo = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Articulo eliminado con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el articulo']);
    }
    $stmt->close();
}
$conn->close();
?>