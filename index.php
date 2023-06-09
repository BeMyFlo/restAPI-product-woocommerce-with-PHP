<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <style>
        /* Đoạn mã CSS bạn muốn thêm vào */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            padding: 20px;
        }

        h1 {
            display: flex;
            font-size: 42px;
            margin-bottom: 20px;
            align-items: center;
            justify-content: center;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-left: -18px;
        }

        li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }
        .column {
            background-color: white;
            margin-left: 576px;
            padding: 16px;
            display: flex;
            width: 20%;
            border: solid 1px #000000;
            justify-content: center;
            border-radius:20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Trang chủ</h1>
        <div class="column">
            <ul>
                <li><a href="create_product.php">Tạo sản phẩm</a></li>
                <li><a href="delete_product.php">Xóa sản phẩm</a></li>
                <li><a href="show_all_product.php">Hiển thị tất cả sản phẩm</a></li>
                <li><a href="show_product.php">Hiển thị sản phẩm</a></li>
                <li><a href="quanly_donhang.php">Quản lý đơn hàng</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
</html>