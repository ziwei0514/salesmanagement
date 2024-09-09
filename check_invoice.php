<?php
include 'config.php';

if (isset($_GET['invoice_no']) && isset($_GET['table'])) {
    $invoice_no = $_GET['invoice_no'];
    $table = $_GET['table'];

    function invoiceExists($conn, $invoice_no, $table) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM $table WHERE invoice_no = ?");
        $stmt->bind_param("s", $invoice_no);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0;
    }

    $exists = invoiceExists($conn, $invoice_no, $table);
    echo json_encode(array('exists' => $exists));
}

$conn->close();
?>
