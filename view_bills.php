<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bills</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
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
        .container {
            flex-grow: 1;
            padding: 40px 20px;
            position: relative;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #444;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            background-color: transparent;
            box-shadow: none;
        }
        th, td {
            padding: 15px 20px;
            text-align: left;
            border: none;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        th {
            background-color: #333;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        tr:hover td {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
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
        h2{
            color:white;
            text-align: center;
            margin-bottom: 40px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="register_account_admin.php">Add User</a></li>
            <li><a href="view_users.php" >View Users</a></li>
            <li><a href="view_bills.php" class="active">View Saved Bills</a></li>
            <li><a href="view_customer.php">View Customers</a></li>
            <li><a href="report.php">View report</a></li>
        </ul>
    </div>
    <div class="container">
        <a href="logout.php" class="logout">Logout</a>
        <h1>Saved Bills</h1>
        
        <?php
        include('db.php');

        // Fetch saved bills from the database
        $sql = "SELECT id, bill_date, bill_data, total_amount, payment_option, membershipno FROM bills";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Bill ID</th><th>Bill Date</th><th>Customer</th><th>Products</th><th>Total Amount</th><th>Payment Option</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $billId = $row["id"];
                $billDate = $row["bill_date"];
                $billData = unserialize($row["bill_data"]);
                $totalAmount = number_format($row["total_amount"], 2);
                $paymentOption = htmlspecialchars($row["payment_option"]);
                $membershipno = htmlspecialchars($row["membershipno"]);

                // Fetch customer information
                $sql_customer = "SELECT name FROM customers WHERE membershipno = ?";
                $stmt_customer = $conn->prepare($sql_customer);
                $stmt_customer->bind_param('s', $membershipno);
                $stmt_customer->execute();
                $result_customer = $stmt_customer->get_result();
                $customer_name = $result_customer->fetch_assoc()['name'] ?? 'Unknown';

                echo "<tr>";
                echo "<td>$billId</td>";
                echo "<td>$billDate</td>";
                echo "<td>$customer_name (Membership No: $membershipno)</td>";
                echo "<td><ul>";

                foreach ($billData as $productId => $productInfo) {
                    $name = $productInfo['name'];
                    $category = $productInfo['category'];
                    $price = $productInfo['price'];
                    $quantity = $productInfo['quantity'];
                    $total = $price * $quantity;

                    echo "<li>$name ($category) - Price: Rs$price, Quantity: $quantity, Total: Rs$total</li>";
                }

                echo "</ul></td>";
                echo "<td>Rs$totalAmount</td>";
                echo "<td>$paymentOption</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No saved bills found.</p>";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>
</body>
</html>