<?php
include "conexion.php";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Datos del formulario
    $nombre_usuario = $_POST['nombre'];
    $email = $_POST['correo'];
    $clave = $_POST['clave'];
    $clave2 = $_POST['clave2'];
    $calle = $_POST['calle'];
    $colonia = $_POST['colonia'];
    $municipio = $_POST['municipio'];
    $estado = $_POST['estado'];
    $cp = $_POST['cp'];


    // Rol 'Usuario'
    $rol = 2;

    //Comprueba si el correo existe para que no se repitan usuarios
    $sql_check_email = $conn->query("SELECT Email FROM Usuarios WHERE Email = '$email'");
    if ($sql_check_email->num_rows > 0) {
        echo "<script>
                alert('El correo electrónico ya está registrado. Por favor, utiliza otro correo.');
                window.location.href = '/luxora proyecto/registro.html'; 
              </script>";
        exit();
    }

    //La consulta SQL para insertar el nuevo usuario
    $sql = $conn->query("INSERT INTO Usuarios (Nombre_usuario, Clave, Email, Rol, Calle, Colonia, Municipio, Estado, CP)
            VALUES ('$nombre_usuario', '$clave', '$email', '$rol', '$calle','$colonia', '$municipio', '$estado', '$cp')");

   
    if ($sql==1) {
        echo "Nuevo usuario registrado exitosamente";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();
?>
