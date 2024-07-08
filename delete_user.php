<?php
// Database connection
include('db.php');

// Check if ID parameter is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user data
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, proceed with deletion
        $row = $result->fetch_assoc();
        $username = $row["username"];
        $email = $row["email"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Delete user
            $sql = "DELETE FROM users WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                // Deletion successful
                echo "<script>alert('User $username ($email) has been deleted.');</script>";
                echo "<script>window.location.replace('admin_home.php');</script>";
                exit();
            } else {
                // Error occurred during deletion
                echo "<script>alert('Error deleting user: " . $conn->error . "');</script>";
            }
        }
    } else {
        // User not found
        echo "<script>alert('User not found');</script>";
    }
} else {
    // ID parameter not set
    echo "<script>alert('User ID not provided');</script>";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Delete User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2;
            padding-top: 50px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        form {
            display: inline-block;
        }

        input[type="submit"],
        a {
            text-decoration: none;
            background-color: #ff3333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 0 10px;
        }

        input[type="submit"]:hover,
        a:hover {
            background-color: #cc0000;
        }
    </style>
</head>

<body>
    <h2>Confirm Deletion</h2>
    <p>Are you sure you want to delete this user?</p>
    <form method="post">
        <input type="submit" value="Delete">
        <a href="admin_home.php">Cancel</a>
    </form>
</body>

</html>