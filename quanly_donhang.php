<!DOCTYPE html>
<html>
<head>
    <title>Quản lý đơn hàng</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Quản lý đơn hàng</h1>

    <?php
    $consumer_key = 'ck_0f561d2e3785002f8bf660b051ea24f342bf5fdd';
    $consumer_secret = 'cs_1887c77645e1c234f8abfea56ea4c6c08f4372b5';
    $site_url = 'https://mitw.shop';

    // Tạo URL API để lấy danh sách đơn hàng
    $request_url = $site_url . '/wp-json/wc/v3/orders';

    // Tạo chuỗi xác thực
    $auth = base64_encode($consumer_key . ':' . $consumer_secret);

    // Tạo header cho request
    $headers = array(
        'Authorization: Basic ' . $auth,
    );

    // Khởi tạo CURL
    $ch = curl_init($request_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Thực hiện request và lấy dữ liệu đơn hàng
    $response = curl_exec($ch);
    curl_close($ch);

    $orders = json_decode($response, true);

    // Hiển thị danh sách đơn hàng
    if (is_array($orders)) {
        echo '<table>';
        echo '<tr><th>ID đơn hàng</th><th>Ngày đặt hàng</th><th>Tổng tiền</th><th>Trạng thái</th><th>Chức năng</th></tr>';
        foreach ($orders as $order) {
            echo '<tr>';
            echo '<td>' . $order['id'] . '</td>';
            echo '<td>' . $order['date_created'] . '</td>';
            echo '<td>' . $order['total'] . '</td>';
            echo '<td>' . $order['status'] . '</td>';
            echo '<td><form action="" method="post"><input type="hidden" name="order_id" value="' . $order['id'] . '"><select name="new_status">
                    <option value="pending">Chờ xử lý</option>
                    <option value="processing">Đang xử lý</option>
                    <option value="completed">Hoàn thành</option>
                    </select>
                    <input type="submit" value="Cập nhật"></form></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Không có đơn hàng.</p>';
    }

    // Xử lý cập nhật trạng thái đơn hàng
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['new_status'];

        // Tạo URL API để cập nhật trạng thái đơn hàng
        $update_url = $site_url . '/wp-json/wc/v3/orders/' . $order_id;

        // Tạo dữ liệu cập nhật
        $data = array(
            'status' => $new_status
        );

        $ch = curl_init($update_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);
        curl_close($ch);

        // Kiểm tra kết quả cập nhật
        $result = json_decode($response, true);
        if (isset($result['id'])) {
            echo '<p>Cập nhật trạng thái thành công cho đơn hàng có ID: ' . $result['id'] . '</p>';
        } else {
            echo '<p>Có lỗi xảy ra khi cập nhật trạng thái đơn hàng.</p>';
        }
    }
    ?>

</body>
</html>