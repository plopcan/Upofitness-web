<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Pedido</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f5f5f5; padding: 15px; text-align: center; }
        .content { padding: 20px 0; }
        .details { background: #f9f9f9; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirmación de tu Pedido</h1>
        </div>
        
        <div class="content">
            <p>Hola {{ $userName }},</p>
            
            <p>¡Gracias por tu compra en Upofitness! Tu pedido ha sido procesado correctamente.</p>
            
            <div class="details">
                <h3>Detalles del pedido:</h3>
                <p><strong>Número de pedido:</strong> {{ $order->id }}</p>
                <p><strong>Fecha de compra:</strong> {{ $order->purchase_date->format('d/m/Y H:i') }}</p>
                <p><strong>Cantidad:</strong> {{ $order->quantity }}</p>
                <p><strong>Total:</strong> {{ number_format($order->total, 2) }} €</p>
                <p><strong>Dirección de envío:</strong> {{ $order->full_address }}</p>
            </div>
            
            <p>Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.</p>
            
            <p>Atentamente,<br>El Equipo de Upofitness</p>
        </div>
    </div>
</body>
</html>