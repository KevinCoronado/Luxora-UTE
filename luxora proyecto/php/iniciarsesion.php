<?php
header('Content-Type: application/json');
session_start(); // Iniciar la sesión

include 'conexion.php';

// Obtener datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Preparar la consulta SQL
$sql = "SELECT * FROM Usuarios WHERE Email = ?";
$stmt = $conn->prepare($sql);

// Verificar si la preparación de la consulta fue exitosa
if (!$stmt) {
    $response = array('success' => false, 'message' => 'Error en la consulta SQL');
    echo json_encode($response);
    exit();
}

// Ejecutar la consulta con el parámetro del usuario
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar la respuesta
$response = array();

if ($result->num_rows > 0) {
    // Usuario encontrado, verificar la contraseña
    $row = $result->fetch_assoc();
    
    if ($row['Estado_activo']) {
        // Verificación de contraseña sin usar password_verify
        if ($password === $row['Clave']) {
            // Contraseña correcta
            $_SESSION['user_id'] = $row['Id_usuario']; // Guardar ID de usuario en la sesión
            $_SESSION['user_role'] = $row['Rol']; // Guardar rol de usuario en la sesión

            if ($row['Rol'] === 1) {
                $response = array('success' => true, 'message' => 'Inicio de sesión exitoso', 'Rol' => 'Admin');
            } elseif ($row['Rol'] === 2) {
                $response = array('success' => true, 'message' => 'Inicio de sesión exitoso', 'Rol' => 'Usuario');
            }
        } else {
            // Contraseña incorrecta
            $response = array('success' => false, 'message' => 'Contraseña incorrecta');
        }
    } else {
        // Usuario inactivo
        $response = array('success' => false, 'message' => 'El usuario está inactivo.');
    }
} else {
    // Usuario no encontrado
    $response = array('success' => false, 'message' => 'Usuario no encontrado');
}

// Enviar la respuesta en formato JSON
echo json_encode($response);

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
