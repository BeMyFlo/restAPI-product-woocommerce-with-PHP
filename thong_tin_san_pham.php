<?php
$consumer_key = 'ck_0f561d2e3785002f8bf660b051ea24f342bf5fdd';
$consumer_secret = 'cs_1887c77645e1c234f8abfea56ea4c6c08f4372b5';
$site_url = 'https://mitw.shop';
$product = null;

// Kiểm tra xem có dữ liệu được gửi từ form hay không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Lấy dữ liệu từ form
    $product_id = $_POST['id'];
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';
    $product_description = isset($_POST['product_description']) ? $_POST['product_description'] : '';
    $product_link = isset($_POST['product_link']) ? $_POST['product_link'] : '';
    
    // Tạo một mảng chứa thông tin sản phẩm cần cập nhật
    $updated_product = array(
        'name' => $product_name,
        'regular_price' => $product_price,
        'description' => $product_description,
    );
    
    // Chuyển đổi mảng thành chuỗi JSON
    $updated_product_json = json_encode($updated_product);
    
    // Tiếp tục xử lý gửi yêu cầu PUT để cập nhật thông tin sản phẩm
    $request_url = $site_url . '/wp-json/wc/v3/products/' . $product_id;
    $auth = base64_encode($consumer_key . ':' . $consumer_secret);

    $headers = array(
        'Authorization: Basic ' . $auth,
        'Content-Type: application/json'
    );

    $ch = curl_init($request_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $updated_product_json);
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
    <title>Sửa sản phẩm</title>
</head>
<body>
    <div class="box">
       <div class="mobile-img">
        <img src="./img/favicon.png" alt="">
       </div>
        <div class="form-box">
          <form action="" method="post">
            <h1 class="Title">SỬA SẢN PHẨM</h1>
            <?php if (isset($product) && isset($product['id'])) : ?>
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <input type="text" name="product_name" placeholder="Tên sản phẩm" value="<?php echo $product['name']; ?>">
                <input type="text" name="product_price" placeholder="Giá" value="<?php echo $product['regular_price']; ?>">
                <input type="text" name="product_description" placeholder="Mô tả" value="<?php echo $product['description']; ?>">
                <input type="text" name="product_link" placeholder="Link ảnh">
                <button class="login" type="submit">Sửa</button>
            <?php else : ?>
                <p>Có lỗi xảy ra khi lấy thông tin sản phẩm.</p>
            <?php endif; ?>
          </form>
          <hr>
        </div>
    </div>
</body>
</html>