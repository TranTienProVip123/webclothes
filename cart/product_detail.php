<?php
include 'db.php';
session_start();

// Check if product ID is set in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare a SQL query to fetch product by ID
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a product was found
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Add product to cart
        $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
        $_SESSION['cart'][$product_id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        ];
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "No product ID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link rel="stylesheet" href="styles_detailproduct.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>
<body>
    <section id="header">
        <a href="#"><img src="../img/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="../home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="../blog.php">Blog</a></li>
                <li><a href="../about.php">About</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <li><a href="../products/product_list.php">Manage</a></li>
                <li id="lg-bag"><a class="active" href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
    </section>

    <div class="product-detail">
        <img src="../img/products/<?php echo !empty($product['image']) ? $product['image'] : 'default-image.jpg'; ?>" alt="">
        <div class="detail-info">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <h3><?php echo number_format($product['price']); ?> đ</h3>

            <label for="size">Kích thước:</label>
            <select id="size" name="size">
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
            </select>

            <label for="color">Màu sắc:</label>
            <select id="color" name="color">
                <option value="black">Đen</option>
                <option value="white">Trắng</option>
                <option value="blue">Xanh</option>
            </select>

            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1">

            <div class="button-container">
                <a href="?id=<?php echo $product['id']; ?>&add_to_cart=1&quantity=1" class="add-to-cart">THÊM VÀO GIỎ HÀNG</a>
                <a href="checkout.php" class="normal">MUA NGAY</a>
            </div>
        </div>
    </div>
</body>
</html>
