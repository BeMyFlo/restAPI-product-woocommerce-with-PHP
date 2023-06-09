<?php
$consumer_key = 'ck_0f561d2e3785002f8bf660b051ea24f342bf5fdd';
$consumer_secret = 'cs_1887c77645e1c234f8abfea56ea4c6c08f4372b5';
$site_url = 'https://mitw.shop';

// Số sản phẩm hiển thị trên mỗi trang
$products_per_page = 8;

// Trang hiện tại (mặc định là trang 1)
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Tạo URL yêu cầu API để lấy danh sách sản phẩm với phân trang
$request_url = $site_url . '/wp-json/wc/v3/products?per_page=' . $products_per_page . '&page=' . $current_page;

// Tạo chuỗi xác thực sử dụng khóa người tiêu dùng và khóa bí mật người tiêu dùng
$auth = base64_encode($consumer_key . ':' . $consumer_secret);

// Đặt các header yêu cầu
$headers = array(
    'Authorization: Basic ' . $auth,
    'Content-Type: application/json'
);

// Khởi tạo một session cURL
$ch = curl_init($request_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Gửi yêu cầu GET để lấy danh sách sản phẩm
$response = curl_exec($ch);
curl_close($ch);

// Chuyển đổi chuỗi JSON thành mảng kết quả
$products = json_decode($response, true);

// Tính tổng số sản phẩm
$total_products = '19';


// Đóng session cURL
curl_close($ch);

// Tính tổng số trang dựa trên số sản phẩm và số sản phẩm trên mỗi trang
$total_pages = ceil($total_products / $products_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./responsive.css"> 
    <link rel="shortcut icon" type="image/png" href="./img/favicon.png"/>
    <title>Danh sách sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        h1 {
            margin-bottom: 20px;
        }
        .list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .list .product {
         width: 23%;
         box-sizing: border-box;
        }
        .product {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            width:25%;
        }
        
        /* .product h2 {
            margin-top: 0;
        } */
        
        .product img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .pagination {
            display: flex;
            margin-top: 20px;
            justify-content: center;
            align-items: center;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .name{
        height: 180px;
        margin-top: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        }
        .name a{
            color:blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="box">
       <div class="mobile-img">
        <img src="./img/favicon.png" alt="">
       </div>
        <div class="form-box">
          <h1>Danh sách sản phẩm</h1>
        <div class="list">
          <?php if ($total_products > 0) : ?>
            <?php foreach ($products as $product) : ?>
              <div class="product">
                <div class="name">
                  <h2><a href="show_product.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></h2>
                </div>
                  <img src="<?php echo $product['images'][0]['src']; ?>" alt="<?php echo $product['name']; ?>">
                  <p><strong>Giá:</strong> <?php echo $product['regular_price']; ?></p>
                  <p><strong>ID:</strong> <?php echo $product['id']; ?></p>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <p>Không tìm thấy sản phẩm.</p>
          <?php endif; ?>
        </div>
          
          <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
              <?php if ($i == $current_page) : ?>
                <span><?php echo $i; ?></span>
              <?php else : ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
              <?php endif; ?>
            <?php endfor; ?>
          </div>
        </div>
    </div>
</body>
</html>