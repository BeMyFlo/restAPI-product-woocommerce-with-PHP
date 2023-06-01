<?php
$consumer_key = 'ck_0f561d2e3785002f8bf660b051ea24f342bf5fdd';
$consumer_secret = 'cs_1887c77645e1c234f8abfea56ea4c6c08f4372b5';
$site_url = 'https://mitw.shop';

// Kiểm tra xem có dữ liệu được gửi từ form hay không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['type']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['link'])) {
    // Lấy dữ liệu từ form
    $product_data = array(
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'regular_price' => $_POST['price'],
        'description' => $_POST['description'],
        'images' => array(
            array(
                'src' => $_POST['link'] // Sử dụng giá trị từ product_link
            )
        )
    );

    $request_url = $site_url . '/wp-json/wc/v3/products';
    $auth = base64_encode($consumer_key . ':' . $consumer_secret);

    $headers = array(
        'Authorization: Basic ' . $auth,
        'Content-Type: application/json',
    );

    // Tạo yêu cầu POST để thêm sản phẩm
    $ch = curl_init($request_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($product_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Lỗi cURL: ' . curl_error($ch);
    }
    curl_close($ch);

    $product = json_decode($response, true);

    if (isset($product['id'])) {
        echo 'Sản phẩm đã được thêm thành công. ID: ' . $product['id'];
    } else {
        echo 'Có lỗi xảy ra khi thêm sản phẩm.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./responsive.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="shortcut icon" type="image/png" href="./img/favicon.png"/>
    <title>Tạo sản phẩm</title>
</head>
<body>
  <!-- PC -->
    <div class="box">
       <div class="mobile-img">
        <img src="./img/favicon.png" alt="">
       </div>
        <div class="form-box">
          <form action="" method="post">
            <h1 class="Title">TẠO SẢN PHẨM</h1>
            <input type="text" name="name" placeholder="Tên sản phẩm">
            <input type="text" name="type" placeholder="Type">
            <input type="text" name="price" placeholder="Giá">
            <input type="text" name="description" placeholder="Mô tả">
            <input type="text" name="link" placeholder="Link ảnh">
            <button class="login" type="submit">Thêm sản phẩm</button>
          </form>
          <hr>
        </div>
    </div>
</body>
</html>
