<?php
include "conexion.php";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Datos del formulario
    $nombre_usuario = $_POST['nombre'];
    $email = $_POST['correo'];
    $clave = $_POST['clave'];
    $calle = $_POST['calle'];
    $colonia = $_POST['colonia'];
    $municipio = $_POST['municipio'];
    $estado = $_POST['estado'];
    $cp = $_POST['cp'];
    $rol =$_POST['rol'];

    //Comprueba si el correo existe para que no se repitan usuarios
    $sql_check_email = $conn->query("SELECT Email FROM Usuarios WHERE Email = '$email'");
    if ($sql_check_email->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'El correo electrónico ya está registrado. Por favor, utiliza otro correo.'
        ]);
        exit();
    }

    //La consulta SQL para insertar el nuevo usuario
    if ($rol == 1){
        $sql = $conn->query("INSERT INTO Usuarios (Nombre_usuario, Clave, Email, Rol, Calle, Colonia, Municipio, Estado, CP, Estado_activo)
            VALUES ('$nombre_usuario', '$clave', '$email', '$rol', 'NA','NA', 'NA', 'NA', 'NA', TRUE)");
    }else{
        $sql = $conn->query("INSERT INTO Usuarios (Nombre_usuario, Clave, Email, Rol, Calle, Colonia, Municipio, Estado, CP, Estado_activo)
            VALUES ('$nombre_usuario', '$clave', '$email', '$rol', '$calle','$colonia', '$municipio', '$estado', '$cp',TRUE)");
    }
    

    //Si el insert fue exitoso regresa respuesta
    if ($sql==1) {
        echo json_encode([
            'success' => true,
            'message' => 'Usuario creado exitosamente.'
        ]);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();
?>
