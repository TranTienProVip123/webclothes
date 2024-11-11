<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                <li><a class="active" href="shop.php">Shop</a></li>

                <!-- Hiển thị "Manage" chỉ cho người dùng có vai trò 'admin' -->
                <?php
                session_start(); // Khởi động phiên làm việc
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                    echo '<li><a href="../products/product_list.php">Manage</a></li>';
                }
                ?>

                <li><a href="../blog.php">Blog</a></li>
                <li><a href="../about.php">About</a></li>
                <li><a href="../contact.php">Contact</a></li>

                <li>
                    <?php
                    // Hiển thị tên người dùng nếu đã đăng nhập
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        echo "<h4>Xin chào, <span>$username</span></h4>";
                    } else {
                        echo "<a href='auth/login.php'><i class='fas fa-user'></i></a>";
                    }
                    ?>
                </li>

                <li><a href="cart.php"><i class="far fa-shopping-bag"></i></a></li>
            </ul>
        </div>
    </section>

    <section id="page-header" style="background-image: url('../img/banner/b1.jpg');">
        <h2>#stayhome</h2>
        <p>Save more with coupons & up to 70% off!</p>
    </section>

    <?php
    // Đã gọi session_start() rồi ở trên, không cần gọi lại ở đây
    include 'db.php'; // Kết nối cơ sở dữ liệu
    
    // Lấy tất cả sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM products"; // Câu lệnh SQL lấy tất cả sản phẩm
    $result = $conn->query($sql); // Thực thi câu lệnh và lấy kết quả
    
    if (isset($_GET['add_to_cart'])) {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['username'])) {
            // Nếu chưa đăng nhập, chuyển hướng đến trang login
            header("Location: ../auth/login.php");
            exit;
        }

        $product_id = $_GET['add_to_cart'];
        $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity; // Cập nhật số lượng sản phẩm
        } else {
            // Lấy thông tin sản phẩm từ database
            $sql = "SELECT * FROM products WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();

            // Thêm sản phẩm vào giỏ hàng
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity
            ];
        }

        // Chuyển hướng lại trang shop sau khi thêm vào giỏ hàng
        header("Location: shop.php");
        exit;
    }
    ?>

    <section id="product1" class="section-p1">
        <div class="pro-container">
            <?php
            // Lấy tất cả sản phẩm từ cơ sở dữ liệu
            while ($product = $result->fetch_assoc()):
                ?>
                <div class="pro">
                    <img src="../img/products/<?php echo !empty($product['image']) ? $product['image'] : 'default-image.jpg'; ?>"
                        alt="">
                    <div class="des">
                        <h5><?php echo $product['name']; ?></h5> <!-- Tên sản phẩm -->
                        <div class="star">
                            <!-- Hiển thị sao (giả sử bạn có dữ liệu đánh giá sao từ cơ sở dữ liệu) -->
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <h4><?php echo number_format($product['price']); ?> đ</h4> <!-- Giá sản phẩm -->
                    </div>
                    <div class="icon-container">
                        <!-- Add to Cart Button and Icon (aligned to the left) -->
                        <a href="?add_to_cart=<?php echo $product['id']; ?>&quantity=1" class="add-to-cart">
                            <button>THÊM VÀO GIỎ</button> 
                            <!-- Icon for adding to cart -->
                        </a>
                        <!-- Product Detail Icon (aligned to the right) -->
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="view-details">
                            <i class="far fa-eye eye-icon"></i> <!-- Icon for viewing details -->
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section id="pagination" class="section-p1">
        <a href="#">1</a>
        <a href="#">2</a>
        <a href="#"><i class="fal fa-long-arrow-alt-right"></i></a>
    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our lastest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>
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