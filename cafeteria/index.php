<?php
include 'query.php';
include 'conexion_db.php';
$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Pedidos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="topbar">
    <h3 class="text-center">Página de Pedidos</h3>
</div>
<div class="sidebar">
    <li><a class="sidebartext" href="index.php">Inicio</a></li>
</div>
<div class="container">
    <h2>Menú de Café</h2>
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="row">
                <?php
                // Utilizamos la función obtenerProductos() del archivo query.php
                $productos = obtenerProductos();

                foreach ($productos as $producto) {
                    echo '<div class="col-6 col-sm-6 col-lg-4 mb-4 d-flex flex-column align-items-center justify-content-center" onclick="addToCart(\'' . $producto['Nombre'] . '\', ' . $producto['Precio'] . ')">';
                    echo '<img src="' . $producto['Imagen'] . '" class="img-fluid" alt="' . $producto['Nombre'] . '">';
                    echo '<div class="text-center">' . $producto['Nombre'] . '<br>$' . $producto['Precio'] . '</div>';
                    echo '<button type="button" class="btn btn-primary mt-2">Agregar al carrito</button>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="selected-products" id="selected-products">
                <h3>Productos Seleccionados</h3>
                <ul id="cart-items" class="list-group"></ul>
            </div>

            <button type="button" class="btn btn-success mt-4" onclick="submitOrder()">Enviar pedido</button>
        </div>
    </div>
</div>

<script src="main.js"></script>

</body>
</html>
