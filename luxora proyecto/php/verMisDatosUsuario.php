<?php
// Conexión a la base de datos
include 'conexion.php';

// Obtener el ID del usuario (esto normalmente se haría a través de la sesión)
session_start();
$id_usuario = $_SESSION['user_id'];

// Consulta para obtener los datos del usuario
$query = "SELECT Nombre_usuario, Email, Clave, Calle, Colonia, Municipio, Estado, CP FROM Usuarios WHERE Id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    echo json_encode($user_data);
} else {
    echo json_encode(['error' => 'Usuario no encontrado']);
}

$stmt->close();
$conn->close();
?>
