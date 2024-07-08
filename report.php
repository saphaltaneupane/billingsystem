<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Database connection
include('db.php');

// Set the date for the report (current day by default)
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Fetch saved bills for the specified date
$sql = "SELECT * FROM bills WHERE DATE(bill_date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$daily_sales = array();

while ($bill = $result->fetch_assoc()) {
    $bill_data = unserialize($bill['bill_data']);
    
    if ($bill_data === false) {
        echo "Error unserializing data for bill ID {$bill['id']}<br>";
        continue;
    }

    foreach ($bill_data as $item) {
        if (!isset($item['name']) || !isset($item['quantity']) || !isset($item['price'])) {
            echo "Missing required fields in bill ID {$bill['id']}<br>";
            continue;
        }

        $product_name = $item['name'];
        $quantity = intval($item['quantity']);
        $price = floatval($item['price']);
        $total = $quantity * $price;

        if (!isset($daily_sales[$product_name])) {
            $daily_sales[$product_name] = array(
                'quantity' => 0,
                'total' => 0
            );
        }

        $daily_sales[$product_name]['quantity'] += $quantity;
        $daily_sales[$product_name]['total'] += $total;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daily Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
        }
        .back-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .back-button a {
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border-radius: 20px;
            transition: background-color 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .back-button a:hover {
            background-color: #2980b9;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #daa520;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Daily Sales Report for <?php echo $date; ?></h1>
    <div class="back-button">
            <a href="admin_home.php">Back</a>
        </div>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Quantity Sold</th>
            <th>Total Amount</th>
        </tr>
        <?php foreach ($daily_sales as $product_name => $data): ?>
        <tr>
            <td><?php echo htmlspecialchars($product_name); ?></td>
            <td><?php echo $data['quantity']; ?></td>
            <td>Rs. <?php echo number_format($data['total'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    
</body>
</html>