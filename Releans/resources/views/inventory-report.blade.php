<!DOCTYPE html>
<html>

<head>
    <title>Inventory Report</title>
</head>

<body>
    <h1>Inventory Report</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Minimum Level</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventory as $item)
                <tr>
                    <td>{{ $item->product_id }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->product_quantity }}</td>
                    <td>{{ $item->product_minimum_level }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
