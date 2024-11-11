<?php
session_start();
include("db.php");

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Kiểm tra nếu order_id là số hợp lệ
    if (!is_numeric($order_id)) {
        echo "<h2>Đơn hàng không hợp lệ.</h2>";
        exit;
    }

    // Lấy thông tin đơn hàng từ bảng `orders`
    $sql = "SELECT o.order_id, o.user_id, o.username, o.address1, o.phone, o.description, o.total_price, o.status, o.order_date
            FROM orders o
            WHERE o.order_id = ?";
    $stmt = $conn->prepare($sql);

    // Kiểm tra lỗi chuẩn bị câu truy vấn
    if ($stmt === false) {
        echo "Lỗi chuẩn bị câu truy vấn: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_result = $stmt->get_result();

    if ($order_result->num_rows > 0) {
        $order = $order_result->fetch_assoc();

        echo '
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .order-container {
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                text-align: center;
            }
            h2, h3 {
                color: #333;
            }
            p {
                color: #666;
                margin: 8px 0;
            }
            .home-button {
                display: inline-block;
                margin-top: 15px;
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s ease;
            }
            .home-button:hover {
                background-color: #0056b3;
            }
        </style>
        ';

        echo "<div class='order-container'>";
        echo "<h2>Đặt hàng thành công! Cảm ơn bạn đã mua sắm.</h2>";
        echo "<h3>Thông tin đơn hàng #$order_id</h3>";
        echo "<p><strong>Tên người nhận:</strong> {$order['username']}</p>";
        echo "<p><strong>Địa chỉ:</strong> {$order['address1']}</p>";
        echo "<p><strong>Số điện thoại:</strong> {$order['phone']}</p>";
        echo "<p><strong>Mô tả:</strong> {$order['description']}</p>";
        echo "<p><strong>Ngày đặt hàng:</strong> " . date("d-m-Y H:i:s", strtotime($order['order_date'])) . "</p>";
        echo "<p><strong>Trạng thái:</strong> {$order['status']}</p>";

        // Hiển thị tổng giá trị đơn hàng
        echo "<h3>Tổng cộng: " . number_format($order['total_price']) . " đ</h3>";
        echo "<a href='../home.php' class='home-button'>Về trang chủ</a>";
        echo "</div>";
    } else {
        echo "<h2>Không tìm thấy hóa đơn.</h2>";
    }
} else {
    echo "<h2>Không có mã đơn hàng.</h2>";
}
?>
