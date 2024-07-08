<?php
// Database connection
include('db.php');

// Get the selected products and quantities
$selectedProducts = $_POST['selected_products'] ?? [];
$quantities = $_POST['quantity'] ?? [];
$payment_option = $_POST['payment_option'] ?? '';
$membershipno = $_POST['membershipno'] ?? '';

$success = false;
$error_message = '';

if (empty($selectedProducts)) {
    $error_message = 'No products selected.';
} else {
    // Start transaction
    $conn->begin_transaction();

    try {
        // Fetch product information and update stock
        $productData = [];
        $placeholders = implode(',', array_fill(0, count($selectedProducts), '?'));
        $stmt = $conn->prepare("SELECT id, name, category, price, stock FROM products WHERE id IN ($placeholders) FOR UPDATE");
        $stmt->bind_param(str_repeat('i', count($selectedProducts)), ...$selectedProducts);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $productId = $row['id'];
            $quantity = $quantities[$productId] ?? 0;

            if ($quantity > $row['stock']) {
                throw new Exception("Not enough stock for product: {$row['name']}");
            }

            $productData[$productId] = [
                'name' => $row['name'],
                'category' => $row['category'],
                'price' => $row['price'],
                'quantity' => $quantity,
            ];

            // Update stock
            $new_stock = $row['stock'] - $quantity;
            $update_stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
            $update_stmt->bind_param('ii', $new_stock, $productId);
            $update_stmt->execute();
            $update_stmt->close();
        }
        $stmt->close();

        // Save the bill information in the database
        $billDate = date('Y-m-d H:i:s');
        $billDataSerialized = serialize($productData);

        $stmt = $conn->prepare("INSERT INTO bills (bill_date, bill_data, total_amount, payment_option, membershipno) VALUES (?, ?, ?, ?, ?)");
        $totalAmount = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $productData));
        $stmt->bind_param('ssdss', $billDate, $billDataSerialized, $totalAmount, $payment_option, $membershipno);

        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();
        $success = true;
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $error_message = $e->getMessage();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Status</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }

        .message-box {
            text-align: center;
            padding: 50px;
            border: 2px solid #4CAF50;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        .message-box h1 {
            font-size: 36px;
            color: #333;
            margin: 20px 0;
        }

        .message-box p {
            font-size: 18px;
            color: #666;
        }

        .tick-mark {
            font-size: 100px;
            color: #4CAF50;
            animation: bounce 0.5s ease-in-out;
        }

        .cross-mark {
            font-size: 100px;
            color: #e74c3c;
            animation: bounce 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
    </style>
    <script>
        setTimeout(function() {
            window.location.href = 'generate_bill.php';
        }, 3000);
    </script>
</head>

<body>
    <div class="message-box">
        <?php if ($success) : ?>
            <div class="tick-mark">&#10004;</div>
            <h1>Bill Saved Successfully</h1>
            <p>Stock has been updated. Redirecting to the billing page...</p>
        <?php else : ?>
            <div class="cross-mark">&#10008;</div>
            <h1>Error Saving Bill</h1>
            <p><?php echo $error_message ?: 'There was an error saving your bill. Please try again.'; ?></p>
        <?php endif; ?>
    </div>
</body>

</html>