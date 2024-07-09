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
    <title>View Customers</title>
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
        .content {
            flex-grow: 1;
            padding: 40px;
            position: relative;
        }
        h2 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: white;
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
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        th {
            background-color: black;
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
        h1{
            color:black;
            text-align: center;
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
            <li><a href="view_customer.php" class="active">View Customers</a></li>
            <li><a href="report.php">View report</a></li>
        </ul>
    </div>
    <div class="content">
        <a href="logout.php" class="logout">Logout</a>
        <h1>Customer Information</h1>
        <?php
        // Database connection
        include('db.php');

        // Fetch customer information from the database
        $sql = "SELECT id, name, membershipno, phoneno, address FROM customers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Customer ID</th><th>Name</th><th>Membership Number</th><th>Phone Number</th><th>Address</th></tr>";

            while ($row = $result->fetch_assoc()) {
                $customerId = $row["id"];
                $name = htmlspecialchars($row["name"]);
                $membershipno = htmlspecialchars($row["membershipno"]);
                $phoneno = htmlspecialchars($row["phoneno"]);
                $address = htmlspecialchars($row["address"]);

                echo "<tr>";
                echo "<td>$customerId</td>";
                echo "<td>$name</td>";
                echo "<td>$membershipno</td>";
                echo "<td>$phoneno</td>";
                echo "<td>$address</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No customers found.</p>";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>
</body>
</html>