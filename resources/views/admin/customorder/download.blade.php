<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .header h2 {
            color: #007bff;
            margin: 0;
            font-size: 26px;
        }

        .header .contact-info {
            text-align: right;
            font-size: 14px;
            line-height: 1.5;
        }

        .details {
            margin: 20px 0;
            font-size: 15px;
        }

        .details strong {
            color: #007bff;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }

        .table thead {
            background-color: #007bff;
            color: #ffffff;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary {
            text-align: right;
            margin-top: 20px;
            font-size: 16px;
        }

        .summary h3 {
            margin: 5px 0;
        }

        .thanks {
            margin-top: 30px;
            text-align: center;
            font-size: 16px;
            color: #007bff;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature p {
            margin: 0;
        }

        .signature h5 {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <h2>viary store</h2>
            <div class="contact-info">
                <p>Viary Store<br>
                    Email: Via123@gmail.com<br>
                    Phone: 085701297321</p>
            </div>
        </div>

        <div class="details">
            <p><strong>Name:</strong> {{ $customOrder->user->name }}<br>
                <strong>Email:</strong> {{ $customOrder->user->email }}<br>
                <strong>Phone:</strong> {{ $customOrder->user->numberphone }}<br>
                <strong>Address:</strong> {{ $customOrder->address }}
            </p>
            <p><strong>Invoice #:</strong> <span style="color: #007bff;">{{ $customOrder->invoice_no }}</span><br>
                <strong>Order Date:</strong> {{ $customOrder->order_date }}<br>
                <strong>Delivery Date:</strong> {{ $customOrder->completion_date }}<br>
                <strong>Payment Type:</strong> {{ $customOrder->payment_type }}
            </p>
        </div>

        <h3>Products</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Bahan</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $customOrder->name }}</td>
                    <td>{{ $customOrder->size }}</td>
                    <td>{{ $customOrder->fabric_type }}</td>
                    <td>{{ $customOrder->qty }}</td>
                    <td>Rp. {{ format_uang($customOrder->price) }}</td>
                    <td>Rp. {{ format_uang($customOrder->total_price) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="summary">
            <h3>Subtotal: Rp. {{ $customOrder->total_price }}</h3>
            <h3>Ongkir: Rp. {{ $customOrder->ongkir }}</h3>
            <h3>Total: Rp. {{ $customOrder->remaining_payment }}</h3>
            <h3 style="color: green;">Payment Status: {{ $customOrder->status }}</h3>
        </div>

        <div class="thanks">
            <p>Thank you for your purchase!</p>
        </div>

        <div class="signature">
            <p>-----------------------</p>
            <h5>Authorized Signature</h5>
        </div>
    </div>
</body>

</html>
