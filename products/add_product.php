<?php
include 'connect.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "img/products/" . basename($image);

    // Kiểm tra và tạo thư mục "img/products/" nếu chưa tồn tại
    if (!file_exists("img/products")) {
        mkdir("img/products", 0777, true);
    }

    // Di chuyển file ảnh đã tải lên vào thư mục đích
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Chuẩn bị câu truy vấn với MySQLi
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");

        // Gắn các biến với câu truy vấn
        $stmt->bind_param("ssds", $name, $description, $price, $image);

        // Thực thi câu truy vấn
        $stmt->execute();

        // Chuyển hướng về trang danh sách sản phẩm
        header("Location: product_list.php");
    } else {
        echo "An error occurred while uploading the image.";
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản phẩm</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .form-group input[type="file"] {
            padding: 5px;
        }

        .form-group input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .form-group input[type="submit"]:focus {
            outline: none;
        }

        .form-group input[type="submit"]:active {
            background-color: #3e8e41;
        }

        .form-group input[type="file"]:focus {
            outline: none;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus {
            border-color: #5cb85c;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Thêm Sản phẩm</h2>
    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Tên sản phẩm</label>
            <input type="text" name="name" id="name" placeholder="Tên sản phẩm" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả sản phẩm</label>
            <textarea name="description" id="description" placeholder="Mô tả sản phẩm"></textarea>
        </div>

        <div class="form-group">
            <label for="price">Giá sản phẩm (VND)</label>
            <input type="number" name="price" id="price" placeholder="Giá sản phẩm" required>
        </div>

        <div class="form-group">
            <label for="image">Ảnh sản phẩm</label>
            <input type="file" name="image" id="image">
        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="Thêm sản phẩm">
        </div>
    </form>
</div>

</body>
</html>
