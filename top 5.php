<?php
$consumer_key = 'ck_0f561d2e3785002f8bf660b051ea24f342bf5fdd';
$consumer_secret = 'cs_1887c77645e1c234f8abfea56ea4c6c08f4372b5';
$site_url = 'https://mitw.shop';

$request_url = $site_url . '/wp-json/wc/v3/reports/top_sellers';
$auth = base64_encode($consumer_key . ':' . $consumer_secret);

$headers = array(
    'Authorization: Basic ' . $auth,
    'Content-Type: application/json',
);

$ch = curl_init($request_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($http_code === 200) {
    $top_sellers = json_decode($response, true);

    echo '<h2 style="text-align: center; font-family: Arial, sans-serif;">Top 5 Sản phẩm bán chạy nhất</h2>';
    echo '<table style="width: 100%; border-collapse: collapse; margin: 0 auto;">';
    echo '<tr style="background-color: #f2f2f2; font-weight: bold; text-align: left;"><th style="padding: 10px;">ID</th><th style="padding: 10px;">Tên sản phẩm</th></tr>';

    foreach ($top_sellers as $product) {
        if (isset($product['name']) && isset($product['product_id'])) {
            echo '<tr style="background-color: #ffffff;"><td style="padding: 10px;">' . $product['product_id'] . '</td><td style="padding: 10px;">' . $product['name'] . '</td></tr>';
        }
    }
    echo '</table>';
} else {
    echo 'Error occurred: ' . $response;
}
?>
