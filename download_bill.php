<?php
require './dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// Database connection
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_products = $_POST['selected_products'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    $payment_option = $_POST['payment_option'] ?? '';
    $membershipno = $_POST['membershipno'] ?? '';

    if (empty($selected_products)) {
        echo "<p>No products selected</p>";
        exit;
    }

    // Initialize variables for bill details
    $billData = [];
    $totalAmount = 0;

    // Loop through selected products to prepare bill data
    foreach ($selected_products as $id) {
        $sql = "SELECT name, category, price FROM products WHERE id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $name = htmlspecialchars($row["name"]);
            $category = htmlspecialchars($row["category"]);
            $price = htmlspecialchars($row["price"]);
            $quantity = isset($quantities[$id]) ? (int)$quantities[$id] : 1;
            $total = $price * $quantity;
            $totalAmount += $total;

            $billData[] = [
                'name' => $name,
                'category' => $category,
                'price' => $price,
                'quantity' => $quantity,
                'total' => $total
            ];
        }
    }

    // Serialize bill data
    $serializedBillData = serialize($billData);

    // Retrieve customer information from the database
    $customerInfo = '';
    if (!empty($membershipno)) {
        $sql_customer = "SELECT name, phoneno, address FROM customers WHERE membershipno = '$membershipno'";
        $result_customer = $conn->query($sql_customer);
        if ($result_customer->num_rows == 1) {
            $row_customer = $result_customer->fetch_assoc();
            $customerName = htmlspecialchars($row_customer["name"]);
            $customerPhone = htmlspecialchars($row_customer["phoneno"]);
            $customerAddress = htmlspecialchars($row_customer["address"]);

            $customerInfo = "<p>Customer Name: $customerName</p>";
            $customerInfo .= "<p>Phone No: $customerPhone</p>";
            $customerInfo .= "<p>Address: $customerAddress</p>";
        }
    }

    // Insert a new record into the bills table and get the bill ID
    $bill_date = date('Y-m-d H:i:s');
    $sql_insert_bill = "INSERT INTO bills (bill_date, bill_data, total_amount, payment_option, membershipno) VALUES ('$bill_date', '$serializedBillData', '$totalAmount', '$payment_option', '$membershipno')";
    if ($conn->query($sql_insert_bill) === TRUE) {
        $bill_id = $conn->insert_id;
    } else {
        echo "Error: " . $sql_insert_bill . "<br>" . $conn->error;
        exit;
    }

    // Initialize HTML for the bill
    $html = '<h1 style="text-align: center;">Supermarket Billing</h1>';
    $html .= '<p style="text-align: left; margin-left: 20px;">Bill Number: ' . $bill_id . '</p>';
    $html .= '<p style="text-align: right; margin-right: 20px;">Mode of Payment: ' . htmlspecialchars($payment_option) . '</p>';
    $html .= $customerInfo; // Include customer information here
    $html .= '<table border="1" style="width: 100%; border-collapse: collapse;">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>Product</th>';
    $html .= '<th>Category</th>';
    $html .= '<th>Price</th>';
    $html .= '<th>Quantity</th>';
    $html .= '<th>Total</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    // Append product rows to HTML
    foreach ($billData as $item) {
        $html .= '<tr>';
        $html .= "<td>{$item['name']}</td>";
        $html .= "<td>{$item['category']}</td>";
        $html .= "<td>Rs.{$item['price']}</td>";
        $html .= "<td>{$item['quantity']}</td>";
        $html .= "<td>Rs." . number_format($item['total'], 2) . "</td>";
        $html .= '</tr>';
    }

    // Add total row to HTML
    $html .= '<tr>';
    $html .= '<td colspan="4" style="text-align: right; font-weight: bold;">Total Amount:</td>';
    $html .= '<td style="font-weight: bold;">Rs.' . number_format($totalAmount, 2) . '</td>';
    $html .= '</tr>';
    $html .= '</tbody>';
    $html .= '</table>';

    // Close the connection
    $conn->close();

    // Initialize DOMPDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('Bill.pdf', ['Attachment' => true]);
}
