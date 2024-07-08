<!DOCTYPE html>
<html>

<head>
    <title>View Bills</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            position: relative;
        }

        h2 {
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

        th,
        td {
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
    </style>
</head>

<body>
    <div class="container">
        <?php
       
        include('db.php');

        // Fetch saved bills from the database
        $sql = "SELECT id, bill_date, bill_data, total_amount, payment_option, membershipno FROM bills";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Saved Bills</h2>";
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
        <div class="back-button">
            <a href="admin_home.php">Back</a>
        </div>
    </div>
</body>

</html>