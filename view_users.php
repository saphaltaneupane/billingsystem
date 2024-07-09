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
    <title>View Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ecf0f1;
            margin: 0;
            padding: 0;
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
        }
        /* h1, h2 {
            color: #daa520;            
        } */
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
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #daa520;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .admin {
            color: #e74c3c;
            font-weight: bold;
        }
        .disabled {
            color: #bdc3c7;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="register_account_admin.php">Add User</a></li>
            <li><a href="view_users.php" class="active">View Users</a></li>
            <li><a href="view_bills.php">View Saved Bills</a></li>
            <li><a href="view_customer.php">View Customers</a></li>
            <li><a href="report.php">View report</a></li>
        </ul>
    </div>
    <div class="content">
        <a href="logout.php" class="logout">Logout</a>
        <h1>User List</h1>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection
                include('db.php');

                // Fetch users from database
                $sql = "SELECT id, username, email FROM users";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $username = htmlspecialchars($row["username"]);
                        $email = htmlspecialchars($row["email"]);

                        // Check if the username is 'admin'
                        $class = ($username == 'admin') ? 'admin' : '';

                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td class='$class'>$username</td>";
                        echo "<td>$email</td>";
                        echo "<td>";
                      
                        if ($username != 'admin') {
                            echo "<a href='update_user.php?id=$id'>Update</a> | ";
                            echo "<a href='delete_user.php?id=$id' class='delete-btn'>Delete</a>";
                        } else {
                            echo "<span class='disabled'>Update</span> | ";
                            echo "<span class='disabled'>Delete</span>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>