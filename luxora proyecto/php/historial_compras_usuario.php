<?php
include 'conexion.php';
session_start();
// Obtener el ID del usuario (RECORDATORIOOOOOO CAMBIAR POR EL ID DE SESSION)
$id_usuario = $_SESSION['user_id'];

// Obtener el número de página actual
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$items_por_pagina = 3;
$offset = ($pagina - 1) * $items_por_pagina;

// Consulta SQL para obtener el total de artículos
$total_query = "SELECT COUNT(*) as total FROM Compras WHERE Id_usuario = ?";
$total_stmt = $conn->prepare($total_query);
$total_stmt->bind_param('i', $id_usuario);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_paginas = ceil($total_items / $items_por_pagina);

$total_stmt->close();

// Consulta SQL para obtener los artículos paginados, ordenados por ID de compra de forma descendente
$query = "SELECT Compras.*, Articulos.Nombre_articulo, Articulos.Imagen, 
                 Usuarios.Calle, Usuarios.Colonia, Usuarios.Municipio, Usuarios.Estado, Usuarios.CP 
          FROM Compras 
          JOIN Articulos ON Compras.Id_articulo = Articulos.Id_articulo 
          JOIN Usuarios ON Compras.Id_usuario = Usuarios.Id_usuario
          WHERE Compras.Id_usuario = ?
          ORDER BY Compras.Id_compra DESC
          LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('iii', $id_usuario, $offset, $items_por_pagina);
$stmt->execute();
$result = $stmt->get_result();

$compras = [];

while ($row = $result->fetch_assoc()) {
    $compras[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode([
    'compras' => $compras,
    'total_paginas' => $total_paginas
]);
?>
