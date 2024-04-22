<!DOCTYPE html>
<html>

<head>
    <title>Popular Products Report</title>
</head>

<body>
    <h1>Popular Products Report</h1>
    <table border="3">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Sales Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($popular as $product)
                <tr>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->sales_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
