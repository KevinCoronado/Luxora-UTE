<?php
include 'conexion.php';

session_start();
$id_usuario = $_SESSION['user_id'];

// Eliminar el usuario
$query = "UPDATE Usuarios SET Estado_activo = FALSE WHERE Id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Cuenta eliminada correctamente']);
    // Destruir la sesión después de eliminar la cuenta
    session_destroy();
} else {
    echo json_encode(['error' => 'Error al eliminar la cuenta']);
}

$stmt->close();
$conn->close();
?>
