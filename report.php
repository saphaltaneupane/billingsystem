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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
        }
        .sidebar h2 {
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background-color: green;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            position: relative;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
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
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="register_account_admin.php">Add User</a></li>
            <li><a href="view_users.php">View Users</a></li>
            <li><a href="view_bills.php">View Saved Bills</a></li>
            <li><a href="view_customer.php">View Customers</a></li>
            <li><a href="report.php" class="active">View report</a></li>
        </ul>
    </div>
    <div class="content">
        <a href="logout.php" class="logout">Logout</a>
        <h1>Daily Sales Report for <?php echo $date; ?></h1>
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
    </div>
</body>
</html>