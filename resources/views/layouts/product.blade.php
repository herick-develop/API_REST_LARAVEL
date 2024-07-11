<!-- resources/views/product.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Product Details</h1>
        
        <div class="product-details">
            <p><strong>ID:</strong> {{ $id }}</p>
        </div>
    </div>
</body>
</html>
