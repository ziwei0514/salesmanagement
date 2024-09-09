<?php
session_start();
include 'config.php'; // 连接数据库

if (isset($_POST['monthYear'])) {
    $monthYear = $_POST['monthYear'];
    list($year, $month) = explode('-', $monthYear);

    // 使用英文月份名称初始化数组
    $months = [
        1 => 'January', 
        2 => 'February', 
        3 => 'March', 
        4 => 'April', 
        5 => 'May', 
        6 => 'June', 
        7 => 'July', 
        8 => 'August', 
        9 => 'September', 
        10 => 'October', 
        11 => 'November', 
        12 => 'December'
    ];

    // 初始化数据数组，将值设置为 0
    $gs_data = array_fill(1, 12, 0);
    $nct_data = array_fill(1, 12, 0);

    // 查询 GS 销售数据
    $sql_gs = "SELECT MONTH(shipping_date) AS month, SUM(amount) AS total FROM gs_sales WHERE YEAR(shipping_date) = ? AND category = 'order' GROUP BY month";
    $stmt_gs = $conn->prepare($sql_gs);
    $stmt_gs->bind_param('i', $year);
    $stmt_gs->execute();
    $result_gs = $stmt_gs->get_result();

    while ($row = $result_gs->fetch_assoc()) {
        $gs_data[$row['month']] = $row['total'];
    }

    // 查询 NCT 销售数据
    $sql_nct = "SELECT MONTH(shipping_date) AS month, SUM(amount) AS total FROM nct_sales WHERE YEAR(shipping_date) = ? AND category = 'order' GROUP BY month";
    $stmt_nct = $conn->prepare($sql_nct);
    $stmt_nct->bind_param('i', $year);
    $stmt_nct->execute();
    $result_nct = $stmt_nct->get_result();

    while ($row = $result_nct->fetch_assoc()) {
        $nct_data[$row['month']] = $row['total'];
    }

    // 准备 JSON 响应数据，使用月份名称而不是数字
    $response = [
        'status' => 'success',
        'months' => array_values($months), // 使用月份的英文名称
        'gs_data' => array_values($gs_data),
        'nct_data' => array_values($nct_data)
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
