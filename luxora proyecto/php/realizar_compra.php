<?php
require_once 'conexion.php'; 

session_start();

// Obtener datos del formulario
$numeroTarjeta = $_POST['numeroTarjeta'];
$fechaCaducidad = $_POST['fechaCaducidad'];
$cvv = $_POST['cvv'];
$carrito = json_decode($_POST['carritoData'], true);
$_SESSION['user_id']; 

// Registrar el método de pago
$sql = "INSERT INTO Metodo_de_pago (Id_usuario, Num_tarjeta, Vencimiento, CVV) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss",$_SESSION['user_id'], $numeroTarjeta, $fechaCaducidad, $cvv);
$stmt->execute();
$id_metodo = $stmt->insert_id;

// Registrar cada compra
foreach ($carrito as $item) {
    //En fecha de llegada se le suma 7 dias a la fecha de compra
    $sql = "INSERT INTO Compras (Id_usuario, Id_articulo, Id_metodo, Cantidad, Fecha_compra, Fecha_arrivo, Precio_total, Talla) VALUES (?, ?, ?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), ?, ?)";
    $stmt = $conn->prepare($sql);
    $precio_total = $item['precio'] * $item['cantidad'];
    $talla = $item['talla'];  // Usa la talla del carrito

    $stmt->bind_param("iiidss", $_SESSION['user_id'], $item['id'], $id_metodo, $item['cantidad'], $precio_total, $talla);
    $stmt->execute();

    // Actualizar la disponibilidad del artículo
    $sql = "UPDATE Articulos SET Disponibilidad = Disponibilidad - ? WHERE Id_articulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $item['cantidad'], $item['id']);
    $stmt->execute();
}

// Limpiar el carrito
setcookie('carrito', '', time() - 3600, '/');

header("Location: ../marcas.html");
exit();
?>
