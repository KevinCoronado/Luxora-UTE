<?php
include "conexion.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];
    $accion = $_POST['accion'];
  

    // Construir la consulta SQL
    if ($accion === "sumar"){
        $sql = "UPDATE Articulos SET Disponibilidad = Disponibilidad + '$cantidad' WHERE Id_articulo = '$id'";
    }if ($accion === "restar"){
        $sql = "UPDATE Articulos SET Disponibilidad = Disponibilidad - '$cantidad' WHERE Id_articulo = '$id'";
    }

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Stock actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el stock']);
        }
    
    }else {
        echo json_encode(['success' => false, 'message' => 'Solicitud inválida']);
    }
$conn->close();
?>