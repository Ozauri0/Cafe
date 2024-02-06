const cartItems = [];

function addToCart(productName, price) {
    cartItems.push({ productName, price });
    updateCart();
}

function updateCart() {
    const cartList = document.getElementById('cart-items');
    cartList.innerHTML = '';

    cartItems.forEach((item, index) => {
        const listItem = document.createElement('li');
        listItem.textContent = `${item.productName} - $${item.price}`;
        listItem.className = 'list-group-item d-flex justify-content-between align-items-center';

        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Eliminar';
        deleteButton.className = 'btn btn-danger';
        deleteButton.onclick = function () {
            cartItems.splice(index, 1);
            updateCart();
        };

        listItem.appendChild(deleteButton);
        cartList.appendChild(listItem);
    });
}

function submitOrder() {
    if (cartItems.length === 0) {
        alert('Agrega productos al carrito antes de enviar el pedido.');
        return;
    }

    console.log('Datos del carrito antes de enviar:', cartItems); // Agregado para verificar en la consola

    // Enviar la orden al servidor mediante Fetch API
    fetch('procesar_pedido.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ cartItems })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);  // Añadido para ver la respuesta servidor en la consola
            // Manejar la respuesta del servidor, por ejemplo, mostrar un mensaje al usuario
            if (data.success) {
                alert('El pedido se ha enviado con éxito');
                // Limpiar el carrito después de enviar la orden
                cartItems.length = 0;
                updateCart();
            } else {
                alert('Hubo un problema al enviar el pedido. Inténtalo de nuevo.');
            }
        })
        .catch(error => {
            console.error('Error al enviar la orden:', error);
            alert('Hubo un problema al enviar el pedido. Inténtalo de nuevo.');
        });
}