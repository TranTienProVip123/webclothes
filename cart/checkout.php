<?php
session_start();
include 'db.php';

$total = array_reduce($_SESSION['cart'], function ($sum, $product) {
    return $sum + ($product['price'] * $product['quantity']);
}, 0);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #121212;
            /* Nền đen */
            color: #ffffff;
            /* Màu chữ trắng */
        }

        .form-control,
        .form-select {
            background-color: #333333;
            /* Nền xám đậm cho input và select */
            color: #ffffff;
            /* Màu chữ trắng */
            border: 1px solid #555555;
            /* Viền xám */
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #444444;
            /* Nền xám đậm hơn khi focus */
            border-color: #777777;
            /* Viền xám đậm hơn khi focus */
        }

        .form-label {
            color: #bbbbbb;
            /* Màu chữ xám nhạt cho label */
        }

        .btn-primary {
            background-color: #1e90ff;
            /* Màu xanh cho nút Place Order */
            border-color: #1e90ff;
            /* Màu viền xanh cho nút Place Order */
        }

        .btn-primary:hover {
            background-color: #1c86ee;
            /* Màu xanh đậm hơn khi hover */
            border-color: #1c86ee;
            /* Màu viền xanh đậm hơn khi hover */
        }
    </style>
</head>

<body>
    <section id="checkout" class="section-p1">
        <h2>Nhập Thông Tin Đặt Hàng</h2>
        <form action="process_checkout.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Tên:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ:</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại:</label>
                <input type="tel" id="phone" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả thêm (nếu có):</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <h3>Tổng tiền: <?php echo number_format($total); ?> đ</h3>
            </div>
            <button type="submit" class="btn btn-primary">Đặt hàng</button>

        </form>
    </section>
</body>

</html>