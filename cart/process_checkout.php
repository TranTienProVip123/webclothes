<?php
session_start();
include("db.php"); // Kết nối cơ sở dữ liệu

// Kiểm tra giỏ hàng có tồn tại và không trống
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<h2>Giỏ hàng của bạn không có sản phẩm nào.</h2>";
    exit;
}

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    echo "<h2>Vui lòng đăng nhập để tiếp tục thanh toán.</h2>";
    exit;
}

$user_id = $_SESSION['user_id'];
$name = htmlspecialchars(trim($_POST['name']));
$address = htmlspecialchars(trim($_POST['address']));
$phone = htmlspecialchars(trim($_POST['phone']));
$description = htmlspecialchars(trim($_POST['description']));

// Tính tổng tiền giỏ hàng
$total_price = 0;
foreach ($_SESSION['cart'] as $product_id => $product) {
    $total_price += $product['price'] * $product['quantity'];
}

// Kiểm tra kết nối với cơ sở dữ liệu
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Bắt đầu giao dịch
$conn->begin_transaction();

try {
    // Thêm đơn hàng vào bảng `orders`
    $sql = "INSERT INTO orders (user_id, username, address1, phone, description, total_price, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        throw new Exception("Không thể chuẩn bị truy vấn SQL.");
    }
    
    // Bind các tham số, thêm $total_price vào câu lệnh
    $stmt->bind_param("issssd", $user_id, $name, $address, $phone, $description, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Lấy ID của đơn hàng vừa tạo

    // Cam kết giao dịch
    $conn->commit();

    // Xóa giỏ hàng sau khi đặt hàng thành công
    unset($_SESSION['cart']);

    // Chuyển hướng đến trang thành công
    header("Location: order_success.php?order_id=$order_id");
    exit;

} catch (Exception $e) {
    // Nếu có lỗi, rollback giao dịch
    $conn->rollback();
    echo "<h2>Đã có lỗi xảy ra: " . $e->getMessage() . "</h2>";
}
?>
