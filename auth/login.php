<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra email và mật khẩu
    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        
        // Chuyển hướng đến trang chủ (dashboard)
        header("Location: ../home.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Email hoặc mật khẩu không chính xác!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #121212;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
        }
        .login-form {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out;
        }
        .login-form:hover {
            transform: translateY(-5px);
        }
        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #bb86fc;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #6c757d;
            background-color: #2c2c2c;
            color: #e0e0e0;
        }
        .form-action {
            margin-top: 20px;
        }
        .btn-primary {
            background-color: #bb86fc;
            border-color: #bb86fc;
            transition: background-color 0.3s ease-in-out;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #8a2be2;
            border-color: #8a2be2;
        }
        .form-check-label {
            margin-left: 5px;
            color: #e0e0e0;
        }
        .alert {
            border-radius: 8px;
            margin-top: 15px;
        }
        .alert-danger {
            background-color: #ff4d4d;
            color: #fff;
        }
        .footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            color: #e0e0e0;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <h2>Đăng nhập</h2>
        
        <!-- Nếu có thông báo lỗi hoặc thành công -->
        <div id="alert-container">
            <!-- Lỗi và thành công sẽ được hiển thị tại đây -->
        </div>
        
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
            </div>
            <div class="form-action">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <p>Chưa có tài khoản? <a href="register.php" class="text-decoration-none text-light">Đăng ký ngay</a></p>
        </div>
    </div>
</div>

<div class="footer">
    <p>&copy; 2024 My Website</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
