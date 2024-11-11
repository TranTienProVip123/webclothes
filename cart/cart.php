<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-U  A-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Web</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
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

    <?php
    session_start(); // Khởi động session để truy cập giỏ hàng
    include 'db.php';
    $total = 0; // Khởi tạo biến tổng
    // Kiểm tra nếu giỏ hàng không có sản phẩm
    if (empty($_SESSION['cart'])) {
        echo "<h1>Giỏ hàng của bạn đang trống.</h1>";
    } else {
        ?>
        <section id="cart" class="section-p1">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Remove</td>
                        <td>Image</td>
                        <td>Product</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Subtotal</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($_SESSION['cart'] as $product_id => $product):
                        $subtotal = $product['price'] * $product['quantity']; // Tính subtotal cho từng sản phẩm
                        $total += $subtotal; // Cộng dồn tổng tiền
                        ?>
                        <tr>
                            <td><a href="remove_cart.php?product_id=<?php echo $product_id; ?>"><i
                                        class="far fa-times-circle"></i></a></td>
                            <td><img src="../img/products/<?php echo !empty($product['image']) ? $product['image'] : 'default-image.jpg'; ?>"
                                    alt=""></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo number_format($product['price']); ?> đ</td>
                            <td>
                                <form action="update_cart.php" method="POST">
                                    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                    <button type="submit">Cập nhật</button>
                                </form>
                            </td>
                            <td><?php echo number_format($subtotal); ?> đ</td> <!-- Hiển thị subtotal của sản phẩm -->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

    <?php } ?>

    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply coupon</h3>
            <div>
                <input type="text" placeholder="Enter your coupon">
                <button class="normal">Apply</button>
            </div>
        </div>
        <div id="subtotal">
            <h3>Cart total</h3>
            <table>
                <tr>
                    <td>Cart Subtotal</td>
                    <td><?php echo number_format($total); ?> đ</td> <!-- Tính tổng tiền giỏ hàng -->
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>Free</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?php echo number_format($total); ?> đ</strong></td> <!-- Tổng tiền -->
                </tr>
            </table>
            <!-- Nút Checkout để thanh toán -->
            <a href="checkout.php" class="normal">Đặt hàng</a>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="../img/logo.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address: </strong> 234 Nguyen Van Dau, Ward 11, Binh Thanh District</p>
            <p><strong>Phone: </strong>0779678910</p>
            <p><strong>Hours: </strong> 9:00 - 22:00, Mon - Sat</p>
            <div class="follow">
                <h4>Follow Us</h4>
                <div class="icon">
                    <a href="https://www.facebook.com/dinhhuy.truong.3910/"><i class="fab fa-facebook-f"></i></a>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <h4>About</h4>
            <a href="#">About us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>

        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="../img/pay/app.jpg" alt="">
                <img src="../img/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateways </p>
            <img src="../img/pay/pay.png" alt="">
        </div>

        <div class="copyright">
            <p>© Copyright Huy's Team. </p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>