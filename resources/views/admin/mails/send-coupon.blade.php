<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Mã giảm giá từ {{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;">
<table align="center" width="600" style="background-color: #fff; border-radius: 8px; overflow: hidden;">
    <tr style="background-color: #e60012; color: white;">
        <td style="padding: 20px; text-align: center;">
            <h1>Cảm ơn bạn đã đồng hành cùng {{ config('app.name') }}!</h1>
            <p style="font-size: 18px;">Chúng tôi tặng bạn mã giảm giá đặc biệt 🎁</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px; text-align: center;">
            <h2 style="color: #e60012;">{{ $coupon->coupon_name }}</h2>
            <p style="font-size: 24px; font-weight: bold;">Mã code: <span style="color: #e60012;">{{ $coupon->coupon_code }}</span></p>
            <p>Áp dụng từ <strong>{{ $coupon->coupon_date_start }}</strong> đến <strong>{{ $coupon->coupon_date_end }}</strong></p>
            <a href="{{ url('/') }}" style="display: inline-block; margin-top: 20px; background-color: #e60012; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none;">
                Mua sắm ngay
            </a>
        </td>
    </tr>
    <tr style="background-color: #f0f0f0;">
        <td style="padding: 20px;">
            <h3>Lý do chọn {{ config('app.name') }}?</h3>
            <ul>
                <li>Giao hàng nhanh, toàn quốc</li>
                <li>Giá cả cạnh tranh</li>
                <li>Hỗ trợ tận tình</li>
            </ul>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px; font-size: 12px; color: #777; text-align: center;">
            {{ config('app.name') }} - Cảm ơn bạn đã luôn đồng hành ❤️
        </td>
    </tr>
</table>
</body>
</html>
