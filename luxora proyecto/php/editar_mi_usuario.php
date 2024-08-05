<?php
include 'conexion.php';

session_start();
$id_usuario = $_SESSION['user_id'];

// Obtener los datos enviados desde el formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$clave = $_POST['clave'];
$calle = $_POST['calle'];
$colonia = $_POST['colonia'];
$municipio = $_POST['municipio'];
$estado = $_POST['estado'];
$cp = $_POST['cp'];

 //Comprueba si el correo existe para que no se repitan usuarios
 $sql_check_email = $conn->query("SELECT Email FROM Usuarios WHERE Email = '$email' AND Id_usuario != $id_usuario");
    if ($sql_check_email->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'El correo electrónico ya está registrado. Por favor, utiliza otro correo.'
        ]);
        exit();
    }

// Actualizar los datos del usuario en la base de datos
$query = "UPDATE Usuarios SET Nombre_usuario = ?, Email = ?, Clave = ?, Calle = ?, Colonia = ?, Municipio = ?, Estado = ?, CP = ? WHERE Id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssssi", $nombre, $email, $clave, $calle, $colonia, $municipio, $estado, $cp, $id_usuario);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Datos actualizados correctamente']);
} else {
    echo json_encode(['error' => 'Error al actualizar los datos']);
}

$stmt->close();
$conn->close();
?>
