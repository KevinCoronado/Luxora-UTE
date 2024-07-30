<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Crear la consulta SQL para obtener los datos requeridos
$sql = "
    SELECT 
        u.Nombre_usuario AS Nombre,
        u.Email AS Correo,
        a.Nombre_articulo AS Articulo,
        a.Marca AS Marca,
        c.Id_compra AS Id_compra,
        c.Talla AS Talla,
        c.Fecha_compra AS FechaCompra,
        c.Fecha_arrivo AS FechaLlegada,
        c.Precio_total AS PrecioMXN
    FROM Compras c
    JOIN Usuarios u ON c.Id_usuario = u.Id_usuario
    JOIN Articulos a ON c.Id_articulo = a.Id_articulo
";

// Ejecutar la consulta
$result = $conn->query($sql);

$compras = array();

if ($result->num_rows > 0) {
    // Salida de los datos de cada fila
    while ($row = $result->fetch_assoc()) {
        $compras[] = $row;
    }
} 

// Codificar el array en JSON
header('Content-Type: application/json');
echo json_encode($compras);

// Cerrar la conexión
$conn->close();
?>
