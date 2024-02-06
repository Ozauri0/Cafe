<?php
include 'conexion_db.php';

// Verificar si la función insertOrderIntoDatabase no está definida antes de declararla
if (!function_exists('insertOrderIntoDatabase')) {
    function insertOrderIntoDatabase($productNames) {
        global $conn;

        foreach ($productNames as $item) {
            $nombreProducto = $conn->real_escape_string($item['productName']); // Escapar datos para prevenir SQL injection
            $precio = "SELECT Precio FROM productos WHERE Nombre = '$nombreProducto'";

            // Obtener el costo de producción del producto

            // Preparar la consulta
            $sql = "INSERT INTO ventas (NombreProducto, Precio) VALUES ('$nombreProducto', '$precio')";

            // Ejecutar la consulta
            if ($conn->query($sql) !== TRUE) {
                // Manejar errores, si es necesario
                error_log('Error al ejecutar la consulta: ' . $conn->error);
            }
        }
    }
}

function obtenerProductos() {
    global $conn;

    $sql = "SELECT * FROM productos";
    $result = $conn->query($sql);

    $productos = array();
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    return $productos;
}

function obtenerCostoProduccion($nombreProducto) {
    global $conn;

    // Escapar datos para prevenir SQL injection
    $nombreProducto = $conn->real_escape_string($nombreProducto);

    // Obtener el costo de producción del producto desde la base de datos
    $sql = "SELECT CostoDeProduccion FROM productos WHERE Nombre = '$nombreProducto'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (float)$row['CostoDeProduccion']; // Asegurar que el costo de producción sea tratado como un número
    } else {
        // Manejar la falta de resultados, si es necesario
        return 0;
    }
}
?>
