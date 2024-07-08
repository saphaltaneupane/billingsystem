<!DOCTYPE html>
<html>

<head>
    <title>View Customers</title>
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
            background-color: white
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
        // Database connection
        include('db.php');

        // Fetch customer information from the database
        $sql = "SELECT id, name, membershipno, phoneno, address FROM customers";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Customer Information</h2>";
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
        <div class="back-button">
            <a href="admin_home.php">Back</a>
        </div>
    </div>
</body>

</html>