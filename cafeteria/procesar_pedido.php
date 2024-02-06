<?php
include 'query.php';

// Establecer el tipo de respuesta a JSON
header('Content-Type: application/json');

// Verificar si se recibieron datos del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if ($data !== null && isset($data['cartItems']) && is_array($data['cartItems'])) {
        $cartItems = $data['cartItems'];

        // Insertar los pedidos en la base de datos
        $result = insertOrderIntoDatabase($cartItems);

        if ($result) {
            // Enviar respuesta de éxito al cliente
            echo json_encode(['success' => true, 'message' => 'El pedido se ha enviado con éxito']);
        } else {
            // Enviar respuesta de error al cliente
            echo json_encode(['success' => false, 'message' => 'Hubo un problema al procesar el pedido. Inténtalo de nuevo.']);
        }
    } else {
        // Enviar respuesta de error al cliente
        echo json_encode(['success' => false, 'message' => 'Datos del carrito no válidos']);
    }
} else {
    // Enviar respuesta de error al cliente
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido']);
}

function insertOrderIntoDatabase($cartItems) {
    include 'conexion_db.php';

    // Obtener la fecha actual en el formato dd/mm/yyyy
    $fecha = date('d/m/Y');

    foreach ($cartItems as $item) {
        $productName = $item['productName'];
        $price = $item['price'];

        // Inserta el pedido en la base de datos
        $sql = "INSERT INTO ventas (NombreProducto, Precio, Fecha) VALUES ('$productName', $price, '$fecha')";

        if ($conn->query($sql) === TRUE) {
            error_log("Nuevo registro creado con éxito");
        } else {
            error_log("Error: " . $sql . "<br>" . $conn->error);
            return false;
        }
    }

    return true;
}
?>