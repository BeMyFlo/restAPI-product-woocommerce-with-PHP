<?php
$consumer_key = 'ck_0f561d2e3785002f8bf660b051ea24f342bf5fdd';
$consumer_secret = 'cs_1887c77645e1c234f8abfea56ea4c6c08f4372b5';
$site_url = 'https://mitw.shop';
$product = null;

// Kiểm tra xem có dữ liệu được gửi từ form hay không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Lấy dữ liệu từ form
    $product_id = $_POST['id']; // ID của sản phẩm cần xóa
$request_url = $site_url . '/wp-json/wc/v3/products/' . $product_id;
$auth = base64_encode($consumer_key . ':' . $consumer_secret);

$headers = array(
    'Authorization: Basic ' . $auth,
);

$ch = curl_init($request_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$product = json_decode($response, true);

if (isset($product['id'])) {
    echo 'Thông tin sản phẩm:<br>';
    echo 'ID: ' . $product['id'] . '<br>';
    echo 'Tên: ' . $product['name'] . '<br>';
    echo 'Giá: ' . $product['price'] . '<br>';
    echo 'Mô tả: ' . $product['description'] . '<br>';
} else {
    echo 'Có lỗi xảy ra khi lấy thông tin sản phẩm.';
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
    <title>Facebook</title>
</head>
<body>
  <!-- PC -->
    <div class="box">
       <div class="mobile-img">
        <img src="./img/favicon.png" alt="">
       </div>
        <div class="form-box">
          <form action="" method="post">
            <h1 class="Title">XEM SẢN PHẨM</h1>
            <input type="text" name="id" placeholder="ID sản phẩm">
            <button class="login" type="submit"></button>
          </form>
          <hr>
          <div id="result"></div>
        </div>
      </div>   
</div>