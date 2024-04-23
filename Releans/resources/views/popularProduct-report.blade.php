<!DOCTYPE html>
<html>

<head>
    <title>Popular Products Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #c4c4c4;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <h1>Popular Products Report</h1>
    <table>
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
