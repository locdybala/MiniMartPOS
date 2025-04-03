<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .invoice-box { width: 100%; padding: 20px; border: 1px solid #ddd; }
        .invoice-box table { width: 100%; border-collapse: collapse; }
        .invoice-box table td, .invoice-box table th { border: 1px solid #ddd; padding: 8px; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
<div class="invoice-box">
    <h2>HÓA ĐƠN BÁN HÀNG</h2>
    <p>Ngày: {{ $order->created_at->format('d/m/Y') }}</p>
    <p>Khách hàng: {{ $order->customer_name ?? 'Khách lẻ' }}</p>
    <p>SĐT: {{ $order->customer_phone ?? 'Không có' }}</p>

    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Tên sản phẩm</th>
            <th>SL</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order->details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                <td>{{ number_format($detail->quantity * $detail->price, 0, ',', '.') }} VNĐ</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h3 class="text-right">Tổng tiền: {{ number_format($order->final_total, 0, ',', '.') }} VNĐ</h3>
    <h4 class="text-right">Phương thức thanh toán: {{ strtoupper($order->payment_method) }}</h4>
</div>
</body>
</html>
