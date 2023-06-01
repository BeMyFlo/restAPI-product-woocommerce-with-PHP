<?php
$consumer_key = 'ck_0f561d2e3785002f8bf660b051ea24f342bf5fdd';
$consumer_secret = 'cs_1887c77645e1c234f8abfea56ea4c6c08f4372b5';
$site_url = 'https://mitw.shop';
$product = null;

// Kiểm tra xem có dữ liệu được gửi từ form hay không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Lấy dữ liệu từ form
    $product_id = $_POST['id']; // ID của sản phẩm cần xem
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
    <title>Xem sản phẩm</title>
</head>
<body>
    <div class="box">
       <div class="mobile-img">
        <img src="./img/favicon.png" alt="">
       </div>
        <div class="form-box">
          <form action="" method="post">
            <h1 class="Title">XEM SẢN PHẨM</h1>
            <input type="text" name="id" placeholder="ID sản phẩm">
            <button class="login" type="submit">XEM</button>
          </form>
          <hr>
          <div id="result">
            <?php if (isset($product) && isset($product['id'])) : ?>
                <div class="product-info">
                    <div class="product-image">
                      <img src="<?php echo $product['images'][0]['src']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-detail">    
                      <h2><?php echo $product['name']; ?></h2>
                      <p class="show" style="color:red">Giá:</p> <p><?php echo $product['regular_price']; ?></p>
                      <br><p class="show" style="color:red">Mô tả: <?php echo $product['description']; ?></p>
                    </div>
                </div>
                  
                <form action="thong_tin_san_pham.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button class="login" type="submit">Sửa</button>
                </form>
            <?php elseif (isset($product) && !isset($product['id'])) : ?>
                <p>Có lỗi xảy ra khi lấy thông tin sản phẩm.</p>
            <?php endif; ?>
          </div>
        </div>
    </div>
</body>
</html>