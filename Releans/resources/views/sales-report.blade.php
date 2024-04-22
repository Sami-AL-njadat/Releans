<!DOCTYPE html>
<html>

<head>
    <title>Sales Report</title>
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
    <div style="text-align: center;">
        {{-- <img src="{{ asset($logoPath) }}" alt="Logo"> --}}
    </div>
    <h1>Sales Report</h1>
    <h4>This report shows the best-selling products and displays the total sales amount
    </h4>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product name</th>
                <th>Product price</th>
                <th>Available Quantity</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->product_id }}</td>
                    <td>{{ $sale->name }}</td>
                    <td>{{ $sale->price }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->total_sales }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
